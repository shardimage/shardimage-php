<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\auth;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephpapi\base\caches\CacheInterface;
use shardimage\shardimagephpapi\web\exceptions\BadGatewayHttpException;
use shardimage\shardimagephpapi\base\exceptions\InvalidCallException;
use shardimage\shardimagephpapi\base\exceptions\InvalidConfigException;
use shardimage\shardimagephpapi\base\exceptions\InvalidParamException;
use shardimage\shardimagephpapi\web\exceptions\MethodNotAllowedHttpException;
use shardimage\shardimagephpapi\api\Request as ApiRequest;
use shardimage\shardimagephpapi\api\Response as ApiResponse;
use shardimage\shardimagephpapi\web\Request as WebRequest;
use shardimage\shardimagephpapi\api\ResponseError;
use shardimage\shardimagephpapi\services\dump\DumpServiceInterface;
use shardimage\shardimagephp\services\AccessTokenService;
use shardimage\shardimagephp\services\SuperBackupService;
use shardimage\shardimagephp\services\SuperBackupLogService;
use shardimage\shardimagephp\services\BillingService;
use shardimage\shardimagephp\services\CloudService;
use shardimage\shardimagephp\services\DataService;
use shardimage\shardimagephp\services\FirewallService;
use shardimage\shardimagephp\services\ImageService;
use shardimage\shardimagephp\services\JobService;
use shardimage\shardimagephp\services\SystemService;
use shardimage\shardimagephp\services\UploadService;
use shardimage\shardimagephp\services\UrlService;

/**
 * Client class provides communication with Shardimage API.
 * 
 * ```php
 * $client = new Client([
 *      'apiKey' => '<apiKey>',
 *      'apiSecret' => '<apiSecret>',
 *      'imageSecret' => '<imageSecret>',
 *      'cloudId' => '<cloudId>',
 * ]);
 * ```
 * 
 */
class Client extends BaseObject
{
    const VERSION = '1.0.0';
    private const URL_SIZE_LIMIT = 14.0;

    /**
     * @var string Shardimage API host
     */
    public $apiHost = 'https://api.shardimage.com';

    /**
     * @var string Shardimage API key
     */
    public $apiKey;

    /**
     * @var string Shardimage API secret
     */
    public $apiSecret;

    /**
     * @var string Shardimage Image secret
     */
    public $imageSecret;

    /**
     * @var string Shardimage API access token
     */
    public $apiAccessToken;

    /**
     * @var string Shardimage API access token secret
     */
    public $apiAccessTokenSecret;

    /**
     * @var string Shardimage API config
     */
    public $apiConfig;

    /**
     * @var string Shardimage image host
     */
    public $imageHost = 'https://img.shardimage.com';

    /**
     * @var string Default cloud ID
     */
    public $cloudId;

    /**
     * @var bool Enable debugging
     */
    public $debug = false;

    /**
     * @var \Psr\Log\LoggerInterface Logger instance.
     */
    public $logger;

    /**
     * @var bool Enable gzip compression
     */
    public $useGzip = true;

    /**
     * @var bool Enable using MsgPack
     */
    public $useMsgPack = true;

    /**
     * @var bool Allow dismissing soft exceptions
     */
    public $softExceptionEnabled = true;

    /**
     * @var string Proxy settings (protocol://host:port)
     */
    public $proxy;

    /**
     * @var CacheInterface Cache interface
     */
    public $cache;

    /**
     * @var int Cache expiration
     */
    public $cacheExpiration;

    /**
     * @var int Request timeout [sec]
     */
    public $timeout = 180;

    /**
     * @var int Maximal task count in batch request
     */
    public $batchLimit = 100;

    /**
     * @var DumpServiceInterface dumping service object
     */
    public $dumpService;

    /**
     * @var Client Shardimage PHP API service
     */
    private $service;

    /**
     * @var mixed Services
     */
    private $services = [];

    /**
     * @var bool Deferred requests
     */
    private $deferred = false;

    /**
     * @var bool Asynchronous requests
     */
    private $async = false;

    /**
     * @var WebRequest Shardimage PHP API request
     */
    private $request;

    /**
     * @var mixed Last error message
     */
    private $lastError;

    /**
     * @var callable[] Request callbacks
     */
    private $callbacks = [];

    /**
     * @var string Shardimage image hostname (overridden by host)
     */
    private $imageHostname;

    /**
     * @var array Sent request Ids
     */
    private $sentContentIds = [];

    /**
     * @var float Maximal URL size in KB
     */
    private $urlSizeLimit = self::URL_SIZE_LIMIT;

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->parseApiConfig();
        if ((isset($this->apiSecret)||isset($this->imageSecret)) && !isset($this->apiKey)) {
            throw new InvalidParamException('Invalid Client, apiKey is required if you use apiSecret or imageSecret!');
        }
        $this->service = new ClientService([
            'host' => $this->apiHost,
            'authData' => new AuthData([
                'key' => $this->apiKey,
                'secret' => $this->apiSecret,
                'oneTimeHash' => $this->apiAccessToken,
            ]),
            'customHeaderPrefix' => 'Shardimage',
            'debug' => $this->debug,
            'logger' => $this->logger,
            'useGzip' => $this->useGzip,
            'useMsgPack' => $this->useMsgPack,
            'proxy' => $this->proxy,
            'cache' => $this->cache,
            'cacheExpiration' => $this->cacheExpiration,
            'timeout' => $this->timeout,
            'dumpService' => $this->dumpService,
        ]);
        $this->imageHostname = parse_url($this->imageHost, PHP_URL_HOST);
    }

    /**
     * @param string $name
     * @return object
     */
    private function getService($name)
    {
        if (!isset($this->services[$name])) {
            $service = '\\shardimage\\shardimagephp\\services\\'.$name.'Service';
            $this->services[$name] = new $service($this);
        }

        return $this->services[$name];
    }

    /**
     * @return AccessTokenService
     */
    public function getAccessTokenService()
    {
        return $this->getService('AccessToken');
    }

    /**
     * @return SuperBackupService
     */
    public function getSuperBackupService()
    {
        return $this->getService('SuperBackup');
    }

    /**
     * @return BillingService
     */
    public function getBillingService()
    {
        return $this->getService('Billing');
    }

    /**
     * @return CloudService
     */
    public function getCloudService()
    {
        return $this->getService('Cloud');
    }

    /**
     * @return DataService
     */
    public function getDataService()
    {
        return $this->getService('Data');
    }

    /**
     * @return FirewallService
     */
    public function getFirewallService()
    {
        return $this->getService('Firewall');
    }

    /**
     * @return ImageService
     */
    public function getImageService()
    {
        return $this->getService('Image');
    }

    /**
     * @return JobService
     */
    public function getJobService()
    {
        return $this->getService('Job');
    }

    /**
     * @return SystemService
     */
    public function getSystemService()
    {
        return $this->getService('System');
    }

    /**
     * @return UploadService
     */
    public function getUploadService()
    {
        return $this->getService('Upload');
    }

    /**
     * @return UrlService
     */
    public function getUrlService()
    {
        return $this->getService('Url');
    }

    /**
     * @return SuperBackupLogService
     */
    public function getSuperBackupLogService()
    {
        return $this->getService('SuperBackupLog');
    }

    /**
     * Setting up deferred request.
     * If setting false and there are defered request, it will send together.
     * 
     * @param bool $enable
     * @return mixed
     */
    public function defer($enable)
    {
        $this->deferred = $enable;

        if (!$this->deferred && isset($this->request)) {
            return $this->doSend();
        }
    }

    /**
     * Setting up async request
     * 
     * @param bool $enable
     * @throws MethodNotAllowedHttpException
     */
    public function async($enable)
    {
        throw new MethodNotAllowedHttpException('Asynchronous mode is currently not supported.');
    }

    /**
     * @param string[] $requiredParams
     * @param array    $params
     * @param callable $callback
     */
    public function send($requiredParams, $params, $callback)
    {
        $params['params'] = $this->fillParams($requiredParams, isset($params['params']) ? $params['params'] : []);
        $params['mode'] = $this->async ? ApiRequest::MODE_ASYNC_PARALLEL : ApiRequest::MODE_SYNC_PARALLEL;
        $params['userAgent'] = 'ShardimagePhpOfficial/'.self::VERSION;
        if (isset($params['getParams']['notificationUrl'])) {
            $params['notificationUrl'] = $params['getParams']['notificationUrl'];
            unset($params['getParams']['notificationUrl']);
        }
        $request = new ApiRequest($params);
        $this->callbacks[$request->id] = $callback;

        if (!$this->deferred || !isset($this->request)) {
            $this->request = new WebRequest($this->service, $request);
        } else {
            $this->request->add($request);
        }

        if (!$this->deferred) {
            $result = $this->doSend();
            return reset($result);
        } else {
            $this->sentContentIds[] = $request->id;
            return $request->id;
        }
    }

    /**
     * Sending deffered request.
     * @return array
     * @throws InvalidCallException
     */
    private function doSend()
    {
        try {
            if (!empty($this->sentContentIds) && count($this->sentContentIds) > $this->batchLimit) {
                throw new InvalidCallException(sprintf("Request limit reached! Max %d requests per batch is accepted!", $this->batchLimit));
            }
            $response = $this->request->send();
            $originalResponse = $response;
            if ($response instanceof ApiResponse) {
                $response = [$response];
            }
            $responses = [];
            $index = 0;
            foreach ($response as $_response) {
                $responses[$_response->id ?? $index] = $this->handleResponse($_response);
                $index++;
            }
            foreach ($this->sentContentIds as $sentContentId) {
                if (!array_key_exists($sentContentId, $responses)) {
                    if ($originalResponse instanceof ApiResponse) {
                        $responses[$sentContentId] = $originalResponse;
                    } else {
                        $responses[$sentContentId] = new ApiResponse([
                            'success' => false,
                            'error' => new ResponseError([
                                'type' => BadGatewayHttpException::class,
                                'code' => ResponseError::ERRORCODE_HTTP_RESPONSE_ERROR,
                                'message' => ['httpError' => 'Sent content not found in response!'],
                                    ]),
                        ]);
                    }
                }
            }
            return $responses;
        } finally {
            $this->request = null;
            $this->sentContentIds = [];
        }
    }

    /**
     * @param ApiResponse|ApiResponse[] $response
     * @return mixed
     */
    private function handleResponse($response)
    {
        if (isset($response->error)) {
            $this->lastError = isset($response->error->message) ? $response->error->message : 'Unknown error!';
        }
        if (isset($this->callbacks[$response->id])) {
            return call_user_func_array($this->callbacks[$response->id], ['response' => $response]);
        }
        return $response;
    }

    /**
     * @param array $requiredParams
     * @param array $params
     * @throws InvalidParamException
     * @return array
     */
    public function fillParams($requiredParams, $params)
    {
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                if (isset($this->$param)) {
                    $params[$param] = $this->$param;
                } else {
                    throw new InvalidParamException('Missing parameter: '.$param);
                }
            }
        }

        return $params;
    }

    /**
     * @param array $params
     * @param string $param
     */
    public function getParam($params, $param)
    {
        if (isset($params[$param])) {
            return $params[$param];
        } elseif (isset($this->$param)) {
            return $this->$param;
        }
    }

    private function parseApiConfig()
    {
        if (isset($this->apiConfig)) {
            $url = parse_url($this->apiConfig);
            $this->apiKey = isset($url['user']) ? $url['user'] : null;
            $this->apiSecret = isset($url['pass']) ? $url['pass'] : null;
            $this->cloudId = isset($url['host']) ? $url['host'] : null;
        }
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @return string
     */
    public function getImageHostName()
    {
        return $this->imageHostname;
    }

    /**
     * @return float
     */
    public function getUrlSizeLimit(): float
    {
        return $this->urlSizeLimit;
    }

    /**
     * @param float $limit
     * @throws InvalidParamException
     */
    public function setUrlSizeLimit($limit): void
    {
        if ($limit > self::URL_SIZE_LIMIT) {
            throw new InvalidParamException(sprintf('Url size limit can\'t be higher than %s', self::URL_SIZE_LIMIT));
        }
        $this->urlSizeLimit = $limit;
    }
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephp\auth\Client;
use shardimage\shardimagephpapi\api\Response;
use shardimage\shardimagephpapi\base\exceptions\Exception;
use shardimage\shardimagephpapi\base\exceptions\InvalidParamException;
use shardimage\shardimagephpapi\web\exceptions\HttpException;

/**
 * Base Shardimage service.
 */
abstract class Service extends BaseObject
{
    /**
     * @var Client Shardimage API Client
     */
    protected $client;

    /**
     * @var string Shardimage module version
     */
    protected $version = 'v1';

    /**
     * @var mixed Last error in the service
     */
    protected $lastError;

    /**
     * Creates the service.
     * 
     * @param Client $client Shardimage Client
     * @param array  $config Configuration
     */
    public function __construct($client, $config = [])
    {
        $this->client = $client;
        parent::__construct($config);
    }

    /**
     * Sends the request to the Shardimage API and returns with the Response
     * object or the ID for the request if deferred.
     *
     * Optionally throws an exception for soft errors.
     * 
     * @param string[] $requiredParams Mandatory API parameters for precheck
     * @param array    $params         API parameters
     * @param callable $callback       Response callback
     *
     * @return Response|string
     *
     * @throws Exception|HttpException
     */
    protected function sendRequest($requiredParams, $params, $callback)
    {
        if (isset($params['getParams']) && is_array($params['getParams'])) {
            $params['getParams'] = $this->formatGetParams($params['getParams']);
        }
        $response = $this->client->send($requiredParams, array_merge($params, [
            'module' => static::getModule(),
            'controller' => static::getController(),
            'version' => $this->version,
        ]), function ($response) use ($callback) {
            if (isset($response->error)) {
                return $response;
            }
            return call_user_func($callback, $response);
        });
        if (isset($response->error)) {
            $this->lastError = isset($response->error->message) ? $response->error->message : 'Unknown error!';
            if ($this->client->softExceptionEnabled) {
                if (isset($response->meta['statusCode']) ? $response->meta['statusCode'] : false) {
                    throw $response->error->exception;
                }
                throw new Exception('API error ' . (isset($response->error->code) ? $response->error->code : -1) . '!');
            }
        }

        return $response;
    }

    /**
     * Format get parameters from array to joined string.
     *
     * @param array $getParams
     * @return array
     * @throws InvalidParamException
     */
    protected function formatGetParams(array $getParams): array
    {
        foreach ($getParams as $name => $value) {
            if (is_object($value)) {
                $value = (string) $value;
            }
            if (is_array($value)) {
                $getParams[$name] = join(',', $value);
            } elseif (!is_string($value) && !is_numeric($value)) {
                throw new InvalidParamException('The get parameter value must to be string, numeric or an array containing the previous types.');
            }
        }
        return $getParams;
    }

    /**
     * Returns the last error in the service.
     * 
     * @return mixed
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @param array $params
     * @param array|IndexParams $optParams
     * @return \shardimage\shardimagephp\services\IndexIterator
     */
    public function indexIterator()
    {
        return new \shardimage\shardimagephp\models\IndexIterator($this);
    }

    /**
     * Shardimage module
     */
    abstract public static function getModule();

    /**
     * Shardimage controller
     */
    abstract public static function getController();
}

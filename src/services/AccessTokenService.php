<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephpapi\api\Response;
use shardimage\shardimagephpapi\base\exceptions\InvalidParamException;
use shardimage\shardimagephp\models\accesstoken\AccessToken;

/**
 * Shardimage security service.
 */
class AccessTokenService extends Service
{
    /**
     * Creates a new access token.
     *
     * @param AccessToken $params    Access Token object
     * @param array  $optParams Optional API parameters
     *
     * @return AccessToken|Response
     *
     * @throws InvalidParamException
     */
    public function create($params, $optParams = [])
    {
        if (!$params instanceof AccessToken) {
            throw new InvalidParamException(AccessToken::class . ' is required!');
        }
        $class = get_class($params);

        return $this->sendRequest([], [
            'restAction' => 'create',
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) use ($class) {
            return isset($response->data) ? new $class($response->data) : $response;
        });
    }

    /**
     * Updates an access token.
     *
     * @param AccessToken $params    Access Token object
     * @param array $optParams Optional API parameters
     *
     * @return AccessToken|Response
     *
     * @throws InvalidParamException
     */
    public function update($params, $optParams = [])
    {
        if (!$params instanceof AccessToken) {
            throw new InvalidParamException(AccessToken::class . ' is required!');
        }
        $class = get_class($params);

        return $this->sendRequest([], [
            'restAction' => 'update',
            'restId' => $params->id,
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) use ($class) {
            return isset($response->data) ? new $class($response->data) : $response;
        });
    }

    /**
     * Deletes an access token.
     *
     * @param AccessToken|string $params    Access Token object or Access Token ID
     * @param array        $optParams Optional API parameters
     *
     * @return bool
     */
    public function revoke($params, $optParams = [])
    {
        if ($params instanceof AccessToken) {
            $params = $params->id;
        }

        return $this->sendRequest([], [
            'restAction' => 'delete',
            'restId' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return $response->success;
        });
    }

    /**
     * Fetches an access token.
     *
     * @param AccessToken|string $params    Access Token object or Access Token ID
     * @param array        $optParams Optional API parameters
     *
     * @return AccessToken|Response
     */
    public function view($params, $optParams = [])
    {
        if (!$params instanceof AccessToken) {
            throw new InvalidParamException(AccessToken::class . ' is required!');
        }
        $class = get_class($params);

        return $this->sendRequest([], [
            'restAction' => 'view',
            'restId' => $params->id,
            'getParams' => $optParams,
        ], function ($response) use ($class) {
            return isset($response->data) ? new $class($response->data) : $response;
        });
    }

    /**
     * Returns whether the access token exists.
     *
     * @param AccessToken|string $params    Access Token object or Access Token ID
     * @param array        $optParams Optional API parameters
     *
     * @return bool
     */
    public function exists($params, $optParams = [])
    {
        if ($params instanceof AccessToken) {
            $params = $params->id;
        }

        return $this->sendRequest([], [
            'restAction' => 'exists',
            'restId' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return $response->success;
        });
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
        return 'secure';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
        return 'access-token';
    }
}

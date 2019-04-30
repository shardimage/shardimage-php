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
use shardimage\shardimagephp\helpers\ArrayHelper;
use shardimage\shardimagephp\models\cloud\Cloud;
use shardimage\shardimagephp\models\cloud\Index;
use shardimage\shardimagephp\models\cloud\IndexParams;

/**
 * Shardimage cloud service.
 */
class CloudService extends Service
{

    /**
     * Fetches all existing clouds.
     * 
     * @param array $params    Required API parameters
     * @param array|IndexParams  $optParams Optional API parameters
     * 
     * <li>projection - an array of projection
     * <li>order - the order of results: name, -name, created, -created
     * <li>maxResults - number of results
     * <li>pageToken - token for next result page
     *
     * @return Index
     */
    public function index($params = [], $optParams = [])
    {
        if ($optParams instanceof IndexParams) {
            $optParams = $optParams->toArray(true);
        }

        return $this->sendRequest([], [
            'restAction' => 'index',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            $clouds = [];
            foreach ($response->data['items'] as $cloud) {
                $clouds[] = new Cloud($cloud);
            }

            return new Index([
                'models' => $clouds,
                'totalCount' => (int) $response->data['totalCount'],
                'nextPageToken' => $response->data['nextPageToken'],
            ]);
        });
    }

    /**
     * Creates a new cloud.
     *
     * @param Cloud $params    Cloud object
     * @param array|Cloud  $optParams Optional API parameters
     *
     * @return Cloud|Response
     *
     * @throws InvalidParamException
     */
    public function create($params, $optParams = [])
    {
        if (!$params instanceof Cloud) {
            throw new InvalidParamException(Cloud::class . ' is required!');
        }

        return $this->sendRequest([], [
            'restAction' => 'create',
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Cloud($response->data) : $response;
        });
    }

    /**
     * Updates a cloud.
     *
     * @param Cloud $params    Cloud object
     * @param array|Cloud  $optParams Optional API parameters
     *
     * @return Cloud|Response
     *
     * @throws InvalidParamException
     */
    public function update($params, $optParams = [])
    {
        if (!$params instanceof Cloud) {
            throw new InvalidParamException(Cloud::class . ' is required!');
        }

        return $this->sendRequest([], [
            'restAction' => 'update',
            'restId' => $params->id,
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Cloud($response->data) : $response;
        });
    }

    /**
     * Deletes a cloud.
     *
     * @param Cloud|string $params    Cloud object or Cloud ID
     * @param array        $optParams Optional API parameters
     *
     * @return bool
     */
    public function delete($params, $optParams = [])
    {
        if ($params instanceof Cloud) {
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
     * Fetches a cloud.
     *
     * @param Cloud|string $params    Cloud object or Cloud ID
     * @param array        $optParams Optional API parameters
     *
     * @return Cloud|Response
     */
    public function view($params, $optParams = [])
    {
        if ($params instanceof Cloud) {
            $params = $params->id;
        }

        return $this->sendRequest([], [
            'restAction' => 'view',
            'restId' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Cloud($response->data) : $response;
        });
    }

    /**
     * Returns whether the cloud exists.
     *
     * @param Cloud|string $params    Cloud object or Cloud ID
     * @param array        $optParams Optional API parameters
     *
     * @return bool
     */
    public function exists($params, $optParams = [])
    {
        if ($params instanceof Cloud) {
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
        return 'cloud';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
        
    }
}

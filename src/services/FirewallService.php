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
use shardimage\shardimagephp\models\firewall\Firewall;
use shardimage\shardimagephp\models\firewall\Index;
use shardimage\shardimagephp\models\firewall\IndexParams;

/**
 * Shardimage firewall service.
 */
class FirewallService extends Service
{
    /**
     * Fetches all firewalls.
     *
     * @param array                     $params    Required API parameters
     * @param FirewallIndexParams|array $optParams Optional API parameters
     *
     * <li>projection - an array of projection flags: noRules, noClouds, noCloudIds
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
            $firewalls = [];
            foreach ($response->data['items'] as $firewall) {
                $firewalls[] = new Firewall($firewall);
            }

            return new Index([
                'models' => $firewalls,
                'totalCount' => (int) $response->data['totalCount'],
                'nextPageToken' => $response->data['nextPageToken'],
            ]);
        });
    }

    /**
     * Creates a firewall.
     *
     * @param Firewall $params    Firewall object
     * @param array    $optParams Optional API parameters
     *
     * @return Firewall|Response
     *
     * @throws InvalidParamException
     */
    public function create($params, $optParams = [])
    {
        if (!$params instanceof Firewall) {
            throw new InvalidParamException(Firewall::class.' is required!');
        }

        return $this->sendRequest([], [
            'restAction' => 'create',
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Firewall($response->data) : $response;
        });
    }

    /**
     * Updates a firewall.
     *
     * @param Firewall $params    Firewall object
     * @param array    $optParams Optional API parameters
     *
     * @return Firewall|Response
     *
     * @throws InvalidParamException
     */
    public function update($params, $optParams = [])
    {
        if (!$params instanceof Firewall) {
            throw new InvalidParamException(Firewall::class.' is required!');
        }

        return $this->sendRequest([], [
            'restAction' => 'update',
            'restId' => $params->id,
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Firewall($response->data) : $response;
        });
    }

    /**
     * Deletes a firewall.
     *
     * @param Firewall|string $params    Firewall object or Firewall ID
     * @param array           $optParams Optional API parameters
     *
     * @return bool
     */
    public function delete($params, $optParams = [])
    {
        if ($params instanceof Firewall) {
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
     * Fetches a firewall.
     *
     * @param Firewall|string $params    Firewall object or Firewall ID
     * @param array           $optParams Optional API parameters
     *
     * @return Firewall|Response
     */
    public function view($params, $optParams = [])
    {
        if ($params instanceof Firewall) {
            $params = $params->id;
        }

        return $this->sendRequest([], [
            'restAction' => 'view',
            'restId' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Firewall($response->data) : $response;
        });
    }

    /**
     * Returns whether the firewall exists.
     *
     * @param Firewall|string $params    Firewall object or Firewall ID
     * @param array           $optParams Optional API parameters
     *
     * @return bool
     */
    public function exists($params, $optParams = [])
    {
        if ($params instanceof Firewall) {
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
        return 'firewall';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }
}

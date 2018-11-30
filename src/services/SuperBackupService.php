<?php

/**
 * @see https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephpapi\api\Response;
use shardimage\shardimagephpapi\base\InvalidParamException;
use shardimage\shardimagephp\helpers\ArrayHelper;
use shardimage\shardimagephp\models\superbackup\SuperBackup;
use shardimage\shardimagephp\models\superbackup\Index;
use shardimage\shardimagephp\models\superbackup\IndexParams;

/**
 * Shardimage superbackup service.
 */
class SuperBackupService extends Service
{
    /**
     * Fetches all existing backups.
     *
     * @param array $params    Required API parameters
     * @param array $optParams Optional API parameters
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
            $backups = [];
            if (isset($response->data['items'])) {
                foreach ($response->data['items'] as $superbackup) {
                    $backups[] = new SuperBackup($superbackup);
                }
            }

            return new Index([
                'models' => $backups,
                'nextPageToken' => $response->data['nextPageToken'],
            ]);
        });
    }

    /**
     * Creates a new superbackup.
     *
     * @param SuperBackup $params    SuperBackup object
     * @param array       $optParams Optional API parameters
     *
     * @return SuperBackup|Response
     *
     * @throws InvalidParamException
     */
    public function create($params, $optParams = [])
    {
        if (!$params instanceof SuperBackup) {
            throw new InvalidParamException(SuperBackup::class.' is required!');
        }
        if(!isset($optParams['cloud'])){
            $optParams['cloud'] = [];
        }
        $optParams['cloud']['id'] = $params->cloud->id;

        return $this->sendRequest([], [
            'restAction' => 'create',
            'uri' => '/c/<cloud.id>',
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new SuperBackup($response->data) : $response;
        });
    }

    /**
     * Updates a superbackup.
     *
     * @param SuperBackup $params    SuperBackup object
     * @param array       $optParams Optional API parameters
     *
     * @return SuperBackup|Response
     *
     * @throws InvalidParamException
     */
    public function update($params, $optParams = [])
    {
        if (!$params instanceof SuperBackup) {
            throw new InvalidParamException(SuperBackup::class.' is required!');
        }
        if(!isset($optParams['cloud'])){
            $optParams['cloud'] = [];
        }
        if ($params->task && is_string($params->task->type)) {
            $params->task = $params->task->type;
        }
        $optParams['cloud']['id'] = $params->cloud->id;
        return $this->sendRequest([], [
            'restAction' => 'update',
            'uri' => '/c/<cloud.id>',
            'restId' => $params->id,
            'postParams' => $params->toArray(),
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new SuperBackup($response->data) : $response;
        });
    }

    /**
     * Deletes a superbackup.
     *
     * @param SuperBackup|string $params    SuperBackup object or SuperBackup ID
     * @param array              $optParams Optional API parameters
     *
     * @return bool
     */
    public function delete($params, $optParams = [])
    {
        if ($params instanceof SuperBackup) {
            $params = $params->id;
        }
        if(!isset($optParams['cloud'])){
            $optParams['cloud'] = [];
        }
        $optParams['cloud']['id'] = $params;
        return $this->sendRequest([], [
            'restAction' => 'delete',
            'uri' => '/c/<cloud.id>',
            'restId' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return $response->success;
        });
    }

    /**
     * Fetches a superbackup.
     *
     * @param SuperBackup|string $params SuperBackup object or SuperBackup ID
     * @param SuperBackup|array $optParams Optional API parameters
     *
     * @return SuperBackup|Response
     */
    public function view($params, $optParams = [])
    {
        if ($params instanceof SuperBackup) {
            $params = $params->id;
        }
        if(!isset($optParams['cloud'])){
            $optParams['cloud'] = [];
        }
        $optParams['cloud']['id'] = $params;
        return $this->sendRequest([], [
            'restAction' => 'view',
            'uri' => '/c/<cloud.id>',
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new SuperBackup($response->data) : $response;
        });
    }

    /**
     * Returns whether the specified superbackup exists.
     *
     * @param SuperBackup|string $params    SuperBackup object or SuperBackup ID
     * @param array              $optParams Optional API parameters
     *
     * @return bool
     */
    public function exists($params, $optParams = [])
    {
        if ($params instanceof SuperBackup) {
            $params = $params->id;
        }
        if(!isset($optParams['cloud'])){
            $optParams['cloud'] = [];
        }
        $optParams['cloud']['id'] = $params;
        return $this->sendRequest([], [
            'restAction' => 'exists',
            'uri' => '/c/<cloud.id>',
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
        return 'super-backup';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }
}

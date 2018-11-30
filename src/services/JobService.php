<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\helpers\ArrayHelper;
use shardimage\shardimagephp\models\job\Job;
use shardimage\shardimagephp\models\job\Index;
use shardimage\shardimagephp\models\job\IndexParams;

/**
 * Shardimage job service.
 */
class JobService extends Service
{

    /**
     * Deletes a job.
     *
     * @param Job|string $params    Job object or Job ID
     * @param array      $optParams Optional API parameters
     *
     * @return bool
     */
    public function delete($params, $optParams = [])
    {
        if ($params instanceof Job) {
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
     * Fetches a job.
     *
     * @param Job|string $params    Job object or Job ID
     * @param array      $optParams Optional API parameters
     *
     * @return Job|null
     */
    public function view($params, $optParams = [])
    {
        if ($params instanceof Job) {
            $params = $params->id;
        }

        return $this->sendRequest([], [
            'restAction' => 'view',
            'restId' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Job($response->data) : $response;
        });
    }

    /**
     * Returns whether the job exists.
     *
     * @param Job|string $params    Job object or Job ID
     * @param array      $optParams Optional API parameters
     *
     * @return bool
     */
    public function exists($params, $optParams = [])
    {
        if ($params instanceof Job) {
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
        return 'job';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephpapi\api\Response;
use shardimage\shardimagephp\models\system\ping\Ping;

/**
 * Shardimage system service.
 */
class SystemService extends Service
{
    /**
     * Pings a Shardimage server and fetches statistical data about the request.
     *
     * @param array $params    Required API parameters
     * @param array $optParams Optional API parameters
     *
     * @return Ping|Response
     */
    public function ping($params = [], $optParams = [])
    {
        return $this->sendRequest([], [
            'restAction' => 'view',
            'restId' => 'ping',
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Ping($response->data) : $response;
        });
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
        return 'system';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }
}

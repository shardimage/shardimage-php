<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\models\billing\Detail;
use shardimage\shardimagephp\models\billing\DetailItem;
use shardimage\shardimagephp\models\billing\DetailParams;
use shardimage\shardimagephp\models\billing\DetailWarning;

/**
 * Shardimage billing service.
 */
class BillingService extends Service
{

    /**
     * Fetches all existing clouds.
     * 
     * @param array $params    Required API parameters
     * @param DetailParams|array  $optParams Optional API parameters
     *
     * @return Detail
     */
    public function detail($params = [], $optParams = [])
    {
        if ($optParams instanceof DetailParams) {
            $optParams = $optParams->toArray(true);
        }

        return $this->sendRequest([], [
            'customAction' => 'detail',
            'method' => 'GET',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            $items = [];
            $warnings = [];
            foreach ($response->data['items'] as $item) {
                $items[] = new DetailItem($item);
            }
            foreach ($response->data['warnings'] as $warning) {
                $warnings[] = new DetailWarning($warning);
            }

            return new Detail([
                'items' => $items,
                'warnings' => $warnings,
            ]);
        });
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
        return 'billing';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
        
    }
}

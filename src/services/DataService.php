<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\data\Cdn;
use shardimage\shardimagephp\data\Continent;
use shardimage\shardimagephp\data\Country;

/**
 * Shardimage data service.
 */
class DataService extends Service
{
    /**
     * Lists all supported Content Delivery Networks.
     * 
     * @param array $params    Required API parameters
     * @param array  $optParams Optional API parameters
     *
     * @return array
     */
    public function cdn($params = [], $optParams = [])
    {
        return Cdn::getAll();
    }

    /**
     * Lists all supported continents.
     *
     * @param array $params    Required API parameters
     * @param array  $optParams Optional API parameters
     *
     * @return array
     */
    public function continent($params = [], $optParams = [])
    {
        return Continent::getAll();
    }

    /**
     * Lists all supported countries.
     *
     * @param array $params    Required API parameters
     * @param array  $optParams Optional API parameters
     *
     * @return array
     */
    public function country($params = [], $optParams = [])
    {
        return Country::getAll();
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }
}

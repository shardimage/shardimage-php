<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\data;

/**
 * Class Continent.
 */
class Continent extends BaseData
{
    const AFRICA = 'AF';
    const ANTARCTICA = 'AN';
    const ASIA = 'AS';
    const EUROPE = 'EU';
    const NORTH_AMERICA = 'NA';
    const OCEANIA = 'OC';
    const SOUTH_AMERICA = 'SA';

    /**
     * @inheritDoc
     */
    protected static function getData()
    {
        return [
            self::AFRICA => 'Africa',
            self::ANTARCTICA => 'Antarctica',
            self::ASIA => 'Asia',
            self::EUROPE => 'Europe',
            self::NORTH_AMERICA => 'North America',
            self::OCEANIA => 'Oceania',
            self::SOUTH_AMERICA => 'South America',
        ];
    }
}

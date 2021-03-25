<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2021 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\indexiterator\services;

use shardimage\shardimagephp\indexiterator\models\Fake;
use shardimage\shardimagephp\indexiterator\models\Index;
use shardimage\shardimagephp\services\Service;

class FakeService extends Service
{
    public static $fakeData = [
        '9li9uXKbomCRZQ5' => 'Forest Ryan',
        'qK5dpItqmoxF3uT' => 'Hadley Heathcote',
        'H9XGnCvfaYRt0AR' => 'Narciso Mertz',
        '7rcxsR8Hjd6pOXJ' => 'Darron Pfannerstill',
        '6aTzi2cXkyHJ1ir' => 'Lavada Schaden',
        '3p_XXnlaX04ofBs' => 'Malachi Gulgowski',
        'dKgvP2YAaXXFRhr' => 'Sydnee Bednar',
        'HzLFFwzS2bvaaZ6' => 'Elliott Cartwright',
        'dv864uJn2R0I4sP' => 'Ken Mann',
        'UUzfwz4uC64AeIu' => 'Evan Parisian',
        'KgdBM0cpgk6JnbN' => 'Joshua Hyatt',
        '_vzeDwbswcbK4_p' => 'Darren Keebler',
        'r4rfQg7ebhmGZqc' => 'Jena Rowe DVM',
        'ZRJ9EWmnxFwMZNi' => 'Marcelle Ondricka',
        'vbalfldPyheARVy' => 'Friedrich Bruen',
        'Y_eQGrkz1oEZv7J' => 'Jack Kunde',
        'QSTllphVWf8p_JB' => 'D\'angelo Keeling',
        'phSZyEQDFdsphdb' => 'Cassandra Padberg',
        'A1mlgSDDbj2YHPO' => 'Emmie Waters',
        'y5jfewM68QvYGvd' => 'Gianni Reilly',
    ];

    public function index($params = [], $optParams = [])
    {
        if ($optParams instanceof IndexParams) {
            $optParams = $optParams->toArray(true);
        }
        $models = [];
        $nextPageToken = false;
        $maxResult = false;
        if (isset($optParams['pageToken'])) {
            $nextPageToken = $optParams['pageToken'];
        }
        $found = ($nextPageToken === false) ? true : false;
        if (isset($optParams['maxResult'])) {
            $maxResult = $optParams['maxResult'];
        }
        $count = 0;
        foreach (self::$fakeData as $id => $name) {
            if ($nextPageToken === $id) {
                $found = true;
            }
            if (!$found) {
                continue;
            }
            $nextPageToken = $id;
            if ($count === $maxResult) {
                break;
            }
            $count++;
            $models[] = new Fake(['id' => $id, 'name' => $name]);
        }
        end(self::$fakeData);
        $lastKey = key(self::$fakeData);
        reset(self::$fakeData);
        if ($nextPageToken === $lastKey) {
            $nextPageToken = false;
        }
        return new Index([
            'models' => $models,
            'totalCount' => count($models),
            'nextPageToken' => $nextPageToken,
        ]);
    }

    protected function sendRequest($requiredParams, $params, $callback)
    {
        throw new \RuntimeException('Not supported!');
    }

    public static function getController()
    {
        throw new \RuntimeException('Not supported!');
    }

    public static function getModule()
    {
        throw new \RuntimeException('Not supported!');
    }

}

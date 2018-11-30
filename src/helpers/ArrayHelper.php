<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\helpers;

class ArrayHelper
{

    /**
     * Decides if given array is associative
     * @param array $array
     * 
     * @return bool
     */
    public static function isAssociative($array)
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @param array $array
     * @param array $keyMap
     */
    public static function changeKeys(&$array, $keyMap)
    {
        foreach ($keyMap as $from => $to) {
            if (isset($array[$from])) {
                $array[$to] = $array[$from];
                unset($array[$from]);
            }
        }
    }
    
    /**
     * @param array $array
     * @param array $keys
     */
    public static function stringify(&$array, $keys) {
        foreach ($keys as $key) {
            if (isset($array[$key]) && !is_string($array[$key])) {
                $array[$key] = (string) $array[$key];
            }
        }
    }
}

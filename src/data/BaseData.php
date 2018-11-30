<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\data;

/**
 * Class BaseData.
 */
abstract class BaseData
{
    /**
     * @return array
     */
    public static function getAll()
    {
        return static::getData();
    }

    /**
     * @param string $id
     *
     * @return mixed|null
     */
    public static function getName($id)
    {
        if (static::has($id)) {
            $data = static::getData();

            return $data[strtoupper($id)];
        }

        return;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public static function has($id)
    {
        $data = static::getData();

        return isset($data[strtoupper($id)]);
    }

    /**
     * @return array
     */
    abstract protected static function getData();
}

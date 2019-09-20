<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\helpers;

class StringHelper
{

    /**
     * Generates a random string of specified length.
     *
     * @param int $length
     * @return string
     * @throws InvalidArgumentException
     */
    public static function generateRandomString($length)
    {
        if (!is_int($length)) {
            throw new \InvalidArgumentException('Length parameter must be an integer');
        }
        if ($length < 1) {
            throw new \InvalidArgumentException('Length parameter must be greater than 0');
        }
        return substr(self::base64UrlEncode(random_bytes($length)), 0, $length);
    }

    /**
     * Encodes string into "Base 64 Encoding
     *
     * @param string $input
     * @return string
     */
    public static function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

}

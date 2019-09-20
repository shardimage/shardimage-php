<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\helpers;

class UploadHelper
{

    /**
     * Generates a random public ID of specified length.
     *
     * @param int $length
     * @param string $prefix
     * @param strng $postfix
     * @return string
     * @throws InvalidArgumentException
     */
    public static function generateRandomPublicId($length = 32, $prefix = '', $postfix = '')
    {
        if (!is_int($length)) {
            throw new \InvalidArgumentException('Length parameter must be an integer');
        }
        if ($length < 1) {
            throw new \InvalidArgumentException('Length parameter must be greater than 0');
        }
        $generateLength = $length - strlen($prefix) - strlen($postfix);
        if ($generateLength <= 0) {
            throw new InvalidArgumentException('The length of prefix and postfix can\'t be bigger then the length overall.');
        }
        return $prefix . StringHelper::generateRandomString($generateLength) . $postfix;
    }

}

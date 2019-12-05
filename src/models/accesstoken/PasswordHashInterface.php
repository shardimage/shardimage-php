<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

/**
 * Password hashing interface
 */
interface PasswordHashInterface
{
    /**
     * Converting the object into array
     * @return array
     */
    public function toArray(): array;
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

use shardimage\shardimagephpapi\base\BaseObject;

/**
 * Extra authentication for image serving
 */
class ImageUrlAccessTokenExtraAuthentication extends BaseObject
{
    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $password;
}

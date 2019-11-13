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
     * Array of authentication data. The format should be:
     *
     * ```php
     * $this->authentication = [
     *     '<username1>' => '<password1>',
     *     '<username2>' => '<password2>',
     * ];
     * ```
     *
     * @var array
     */
    public $authentication;

    /**
     * @inheritDoc
     */
    public function __construct($config = [])
    {
        if ($config) {
            $this->authentication = $config;
        }
        $this->init();
    }

    /**
     * Setting up authentication data.
     *
     * @param string $username
     * @param string $password
     *
     * @return $this the object itself
     */
    public function setAuthenticationData($username, $password)
    {
        if (!is_array($this->authentication)) {
            $this->authentication = [];
        }
        $this->authentication[$username] = $password;

        return $this;
    }
}

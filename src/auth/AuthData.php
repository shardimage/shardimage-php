<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\auth;

use shardimage\shardimagephpapi\api\auth\BaseAuthData;
use shardimage\shardimagephp\helpers\SecurityHelper;

/**
 * AuthData class for authentication.
 */
class AuthData extends BaseAuthData
{
    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $secret;

    /**
     * @var string
     */
    public $oneTimeHash;

    /**
     * @inheritDoc
     */
    public function credentials()
    {
        if (isset($this->oneTimeHash)) {
            return ['one-time' => $this->oneTimeHash];
        } else {
            return [
                'Key' => $this->key,
                'Signature' => SecurityHelper::generateSignature($this->uri, $this->key, $this->secret),
            ];
        }
    }
}

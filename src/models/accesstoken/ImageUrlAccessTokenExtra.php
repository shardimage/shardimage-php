<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephp\models\accesstoken\ImageUrlAccessTokenExtraAuthentication;

/**
 * Additional extras for the access token
 */
class ImageUrlAccessTokenExtra extends BaseObject
{
    /**
     * @var string
     */
    public $cloudId;

    /**
     * @var string
     */
    public $secret;

    /**
     * @var array|ImageUrlAccessTokenExtraAuthentication
     */
    public $authentication;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->ensureClass('authentication', ImageUrlAccessTokenExtraAuthentication::class);
    }

    /**
     * @inheritDoc
     */
    public function toArray($excludeEmpty = false)
    {
        if ($this->authentication instanceof ImageUrlAccessTokenExtraAuthentication) {
            $auth = $this->authentication->toArray();
            $this->authentication = $auth['authentication'] ?? null;
        }
        $result = parent::toArray(true);
        $this->ensureClass('authentication', ImageUrlAccessTokenExtraAuthentication::class);
        return $result;
    }
}

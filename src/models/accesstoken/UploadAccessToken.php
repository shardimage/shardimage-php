<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

/**
 * UploadAccessToken class provides AccessToken for image uploading
 */
class UploadAccessToken extends AccessToken
{

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return 'upload';
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->ensureClass('extra', UploadAccessTokenExtra::class);
    }
}

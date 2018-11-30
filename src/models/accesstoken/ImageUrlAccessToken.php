<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

/**
 * ImageUrlAccessToken class provides AccessToken for image serving
 * 
 * ```php
 * use shardimage\shardimagephp\models\accesstoken\ImageUrlAccessToken;
 * use shardimage\shardimagephp\models\accesstoken\ImageUrlAccessTokenExtra;
 * use shardimage\shardimagephp\models\accesstoken\ImageUrlAccessTokenExtraAuthentication;
 * 
 * $token = new ImageUrlAccessToken();
 * $token->expiry = time() + 3600;
 * $token->limit = 1000;
 * $token->extra = new ImageUrlAccessTokenExtra([
 *      'cloudId' => '<cloudId>',
 *      'secret' => '<secretString>',
 *      'authentication' => new ImageUrlAccessTokenExtraAuthentication(['user' => 'username', 'password' => 'password']),
 * ]);
 * $response = $client->getAccessTokenService()->create($token);
 * ```
 */
class ImageUrlAccessToken extends AccessToken
{

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return 'imageUrl';
    }

    /**
     * @inheritDoc
     */
    protected function init()
    {
        parent::init();
        $this->ensureClass('extra', ImageUrlAccessTokenExtra::class);
    }
}

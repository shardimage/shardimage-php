<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup\targets;

class CloudinaryTarget extends Target
{

    /**
     * @var string Cloudinary Cloud name
     */
    public $cloudName;

    /**
     * @var string Cloudinary Api Key.
     */
    public $apiKey;

    /**
     * @var string Cloudinary Api Secret
     */
    public $apiSecret;

    public static function getType()
    {
        return 'cloudinary';
    }
}

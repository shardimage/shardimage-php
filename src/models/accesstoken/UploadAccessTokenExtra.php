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
 * Additional extras for the upload access token
 */
class UploadAccessTokenExtra extends BaseObject
{
    /**
     * @var null|string
     */
    public $transformation;

    /**
     * @var null|string
     */
    public $transformationPrefix;

    /**
     * @var null|string
     */
    public $transformationPostfix;

    /**
     * @var null|string
     */
    public $format;

    /**
     * @var null|string
     */
    public $cloudId;

    /**
     * @var null|string
     */
    public $projection;

    /**
     * @var null|array
     */
    public $tags;

    /**
     * @var null|array
     */
    public $addTags;

    /**
     * @var null|array
     */
    public $notificationUrls;

    /**
     * @var null|string
     */
    public $publicId;
}

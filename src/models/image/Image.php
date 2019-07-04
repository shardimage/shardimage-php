<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\image;

use shardimage\shardimagephpapi\base\BaseObject as BaseObject;

class Image extends BaseObject
{

    const ORIENTATION_TOP_LEFT = 1;
    const ORIENTATION_TOP_RIGHT = 2;
    const ORIENTATION_BOTTOM_RIGHT = 3;
    const ORIENTATION_BOTTOM_LEFT = 4;
    const ORIENTATION_LEFT_TOP = 5;
    const ORIENTATION_RIGHT_TOP = 6;
    const ORIENTATION_RIGHT_BOTTOM = 7;
    const ORIENTATION_LEFT_BOTTOM = 8;
    const FORMAT_JPEG = 'jpg';
    const FORMAT_PNG = 'png';

    public $publicId;
    public $cloudId;
    public $createdAt;

    /**
     * @var ImageObject
     */
    public $object;
    public $orientation;
    public $format;
    public $mimeType;

    /**
     * @var Dimensions
     */
    public $dimensions;
    public $metadata;
    public $metadataXml;
    public $tags;
    public $perceptualHash;
    public $faces;
    public $eyes;
    public $bodies;

    /**
     * @var array Super backup information
     */
    public $superBackup;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->ensureClass('dimensions', Dimensions::class);
        $this->ensureClass('object', ImageObject::class);
    }

}

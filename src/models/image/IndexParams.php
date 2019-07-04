<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\image;

use shardimage\shardimagephp\models\IndexParams as BaseIndexParams;
use shardimage\shardimagephp\models\image\ViewParams;

class IndexParams extends BaseIndexParams
{

    const TOKEN_SHORT_TIME = 'shortTime';
    const TOKEN_LONG_TIME = 'longTime';
    const ORDER_LATEST = 'latest';
    const ORDER_PUBLIC_ID = 'publicId';
    
    /**
     * Projections
     */
    const PROJECTION_NO_OBJECT = ViewParams::PROJECTION_NO_OBJECT;
    const PROJECTION_NO_EXIF = ViewParams::PROJECTION_NO_EXIF;
    const PROJECTION_NO_DIMENSIONS = ViewParams::PROJECTION_NO_DIMENSIONS;
    const PROJECTION_METADATA = ViewParams::PROJECTION_METADATA;
    const PROJECTION_METADATA_HR = ViewParams::PROJECTION_METADATA_HR;
    const PROJECTION_METADATA_XML = ViewParams::PROJECTION_METADATA_XML;
    const PROJECTION_NO_TAGS = ViewParams::PROJECTION_NO_TAGS;
    const PROJECTION_DETECTION = ViewParams::PROJECTION_DETECTION;
    const PROJECTION_SUPERBACKUP_INFO = ViewParams::PROJECTION_SUPERBACKUP_INFO;

    public $nextPageTokenType;
    public $prefix;
    public $byTag;

}

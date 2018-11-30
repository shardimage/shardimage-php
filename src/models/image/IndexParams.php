<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\image;

use shardimage\shardimagephp\models\IndexParams as BaseIndexParams;

class IndexParams extends BaseIndexParams
{
    const TOKEN_SHORT_TIME = 'shortTime';
    const TOKEN_LONG_TIME = 'longTime';
    const ORDER_LATEST = 'latest';
    const ORDER_PUBLIC_ID = 'publicId';
    const PROJECTION_NO_EXIF = 'noExif';
    const PROJECTION_NO_OBJECT = 'noObject';
    const PROJECTION_NO_DIMENSIONS = 'noDimensions';

    public $nextPageTokenType;
    public $prefix;
    public $byTag;
}

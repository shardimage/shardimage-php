<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup\targets;

class GoogleCloudStorageTarget extends Target
{
    public static function getType()
    {
        return 'googleCloudStorage';
    }
}

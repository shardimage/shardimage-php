<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models;

use shardimage\shardimagephpapi\base\BaseObject;

abstract class Index extends BaseObject
{
    public $models = [];
    public $nextPageToken;
}

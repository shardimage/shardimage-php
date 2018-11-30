<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\job;

use shardimage\shardimagephpapi\base\BaseObject;

class Result extends BaseObject
{
    public $successCount;
    public $failCount;
    public $count;
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\system\ping;

use shardimage\shardimagephpapi\base\BaseObject;

class Request extends BaseObject
{
    public $startedAt;
    public $runnedAt;
    public $method;
    public $contentSize;
    public $contentId;
}

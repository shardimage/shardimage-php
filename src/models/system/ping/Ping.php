<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\system\ping;

use shardimage\shardimagephpapi\base\BaseObject;

class Ping extends BaseObject
{
    public $ping;
    public $server;
    public $request;

    public function init()
    {
        $this->ensureClass('request', Request::class);
    }
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\firewall;

use shardimage\shardimagephpapi\base\BaseObject;

class Rules extends BaseObject
{
    public $ipAccept;
    public $ipDeny;
    public $countryAccept;
    public $countryDeny;
    public $continentAccept;
    public $continentDeny;
    public $cdnAccept;
    public $cdnDeny;
    public $torDeny;
    public $publicProxyDeny;
    public $blockIfNotMatchAllow;
}

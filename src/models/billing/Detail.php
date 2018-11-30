<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\billing;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephp\models\billing\DetailItem;
use shardimage\shardimagephp\models\billing\DetailWarning;

/**
 * Detail class for listing billing detail items and warnings
 */
class Detail extends BaseObject
{

    /**
     * @var DetailItem
     */
    public $items = [];

    /**
     * @var DetailWarning
     */
    public $warnings = [];
    
}

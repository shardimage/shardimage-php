<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */
namespace shardimage\shardimagephp\models\billing;

use shardimage\shardimagephpapi\base\BaseObject;

class DetailItem extends BaseObject
{
    /**
     * @var integer
     */
    public $timestamp;

    /**
     * @var string
     */
    public $cloudId;

    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $type;

    /**
     * @var float
     */
    public $estimatedValue;
    
    /**
     * @var float
     */
    public $estimatedAmount;
}

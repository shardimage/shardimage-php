<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup\targets;

use shardimage\shardimagephpapi\base\BaseObject;

abstract class Target extends BaseObject
{

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $prefix;

    /**
     * @var string Name of bucket.
     */
    public $bucket;

    /**
     * @inheritDoc
     */
    protected function init()
    {
        parent::init();
        $this->type = static::getType();
    }

    abstract public static function getType();

    /**
     * @inheritdoc
     */
    protected function getToArrayAttributes()
    {
        return array_merge(parent::getToArrayAttributes(), ['type']);
    }

}

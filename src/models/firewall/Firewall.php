<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\firewall;

use shardimage\shardimagephpapi\base\BaseObject;

class Firewall extends BaseObject
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $createdAt;

    /**
     * @var integer
     */
    public $updatedAt;

    /**
     * @var Rules
     */
    public $rules;

    /**
     * @var array cloud IDs you want to add the firewall
     */
    public $cloudIds = [];

    /**
     * @var Cloud[] objects you want to add the firewall
     */
    public $clouds = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->ensureClass('rules', Rules::class);
    }
}

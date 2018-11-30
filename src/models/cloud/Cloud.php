<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\cloud;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephp\models\cloud\Info;
use shardimage\shardimagephp\models\firewall\Firewall;

class Cloud extends BaseObject
{
    /**
     * @var string ID of the cloud
     */
    public $id;

    /**
     * @var string name of the cloud
     */
    public $name;

    /**
     * @var string description of the cloud
     */
    public $description;

    /**
     * @var integer timestamp, when the cloud was created
     */
    public $createdAt;

    /**
     * @var integer timestamp, when the cloud was last modified
     */
    public $updatedAt;

    /**
     * @var array settings
     * @todo independent class
     */
    public $settings;

    /**
     * @var Firewall if the cloud has firewall
     */
    public $firewall;

    /**
     * @var bool is the cloud has super backup
     */
    public $hasSuperBackup;

    /**
     * @var Info storage information
     */
    public $info;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->ensureClass('info', Info::class);
        $this->ensureClass('firewall', Firewall::class);
    }
}

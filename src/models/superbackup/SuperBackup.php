<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephp\models\cloud\Cloud;
use shardimage\shardimagephp\models\superbackup\targets\AmazonS3Target;
use shardimage\shardimagephp\models\superbackup\targets\CloudinaryTarget;
use shardimage\shardimagephp\models\superbackup\targets\GoogleCloudStorageTarget;
use shardimage\shardimagephp\models\superbackup\targets\MicrosoftAzureStorageTarget;

class SuperBackup extends BaseObject
{
    const FULL_BACKUP_STATUS_PROCESSING = 'processing';
    const FULL_BACKUP_STATUS_COMPLETE = 'complete';
    const FULL_BACKUP_STATUS_WAITING = 'waiting';
    const FULL_BACKUP_STATUS_STOPPING = 'stopping';
    const FULL_BACKUP_STATUS_STOPPED = 'stopped';

    /**
     * @var Cloud
     */
    public $cloud;

    /**
     * @var integer copy delay [s]
     */
    public $copyDelay;

    /**
     * @var integer|null delete delay [s], never deletes if null
     */
    public $deleteDelay;

    /**
     * @var AmazonS3Target|CloudinaryTarget|GoogleCloudStorageTarget|MicrosoftAzureStorageTarget
     */
    public $target;

    /**
     * @var integer
     */
    public $createdAt;

    /**
     * @var integer
     */
    public $updatedAt;

    /**
     * @var integer keeping logs [days]
     */
    public $logLife;

    /**
     * @var Task
     */
    public $task;

    /**
     * @inheritDoc
     */
    public function init()
    {
        static $targets = [
            AmazonS3Target::class,
            CloudinaryTarget::class,
            GoogleCloudStorageTarget::class,
            MicrosoftAzureStorageTarget::class,
        ];

        if (isset($this->target['type'])) {
            foreach ($targets as $targetClass) {
                if ($this->target['type'] == $targetClass::getType()) {
                    $this->ensureClass('target', $targetClass);
                    break;
                }
            }
        }
        if ($this->createdAt) {
            $this->ensureClass('task', Task::class);
        }
        $this->ensureClass('cloud', Cloud::class);
    }
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup;

use shardimage\shardimagephpapi\base\BaseObject;

class Task extends BaseObject
{
    const TASK_FORCE_COPY_ALL = 'forceCopyAll';
    const TASK_SCAN_AGAIN_AND_COPY = 'scanAgainAndCopy';

    /**
     * @var string|null type of the task
     */
    public $type;

    /**
     * @var string|null status of the task
     */
    public $status;
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\job;

use shardimage\shardimagephpapi\base\BaseObject;

class Job extends BaseObject
{
    public $jobId;
    public $status;
    public $createdAt;
    public $completedAt;

    /**
     * @var Result
     */
    public $result;

    public function init()
    {
        $this->ensureClass('result', Result::class);
    }
}

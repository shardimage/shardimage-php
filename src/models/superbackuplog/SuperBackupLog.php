<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackuplog;

use shardimage\shardimagephpapi\base\BaseObject;

class SuperBackupLog extends BaseObject
{

    const LOG_TYPE_DELETE = 'delete';
    const LOG_TYPE_UPLOAD = 'upload';

    /**
     * @var string 
     */
    public $id;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $publicId;

    /**
     * @var float
     */
    public $createdAt;

    /**
     * @var string 
     */
    public $type;

    /**
     * @var bool
     */
    public $isError;

    /**
     * @var bool 
     */
    public $isCurrentSession;

    /**
     * @var string 
     */
    public $destinationObjectPath;

}

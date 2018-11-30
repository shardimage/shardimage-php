<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup\targets;

class MicrosoftAzureStorageTarget extends Target
{
    /**
     * @var string Account name of Microsoft Azure Storage.
     */
    public $accountName;

    /**
     * @var string Account key of Microsoft Azure Storage.
     */
    public $accountKey;

    public static function getType()
    {
        return 'microsoftAzureStorage';
    }
}

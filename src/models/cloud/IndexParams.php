<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\cloud;

use shardimage\shardimagephp\models\IndexParams as BaseIndexParams;

class IndexParams extends BaseIndexParams
{
    const PROJECTION_NO_SETTINGS = 'noSettings';
    const PROJECTION_NO_FIREWALL = 'noFirewall';
    const PROJECTION_NO_BACKUP = 'noSuperBackup';
    const PROJECTION_WITH_INFO = 'info';
    const ORDER_CREATED_ASC = 'created';
    const ORDER_CREATED_DESC = '-created';
    const ORDER_NAME_ASC = 'name';
    const ORDER_NAME_DESC = '-name';
}

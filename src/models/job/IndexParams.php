<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\job;

use shardimage\shardimagephp\models\IndexParams as BaseIndexParams;

class IndexParams extends BaseIndexParams
{
    const PROJECTION_NO_OUTPUT = 'noOutput';
    const ORDER_CREATED_ASC = 'created';
    const ORDER_CREATED_DESC = '-created';

    public $status;

    public function toArray($excludeEmpty = false)
    {
        $result = parent::toArray($excludeEmpty);
        if (isset($result['status']) && !empty($result['status'])) {
            $result['status'] = implode(',', $result['status']);
        }

        return $result;
    }
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */
namespace shardimage\shardimagephp\models\billing;

use shardimage\shardimagephpapi\base\BaseObject;

/**
 * DetailParams class for listing
 */
class DetailParams extends BaseObject
{
    const DATE_PARTITION_DAY = 'day';
    const DATE_PARTITION_HOUR = 'hour';
    const DATE_PARTITION_QUARTER_HOUR = 'quarterHour';
    const GROUP_CU = 'cu';
    const GROUP_EGRESS = 'egress';
    const GROUP_STORAGE = 'storage';
    const PROJECTION_ESTIMATED_AMOUNT = 'estimatedAmount';
    const PROJECTION_BY_CLOUD = 'byCloud';
    const PROJECTION_BY_TYPE = 'byType';
    
    /**
     * @var integer
     */
    public $dateTo;

    /**
     * @var integer
     */
    public $dateFrom;

    /**
     * @var string
     */
    public $datePartition;

    /**
     * @var string
     */
    public $cloudId;

    /**
     * @var string
     */
    public $group;

    /**
     * @var array
     */
    public $groupFilter = [];

    /**
     * @var array
     */
    public $projection = [];
    
    /**
     * @inheritDoc
     */
    public function toArray($excludeEmpty = false)
    {
        $result = parent::toArray($excludeEmpty);
        if (isset($result['projection']) && !empty($result['projection'])) {
            $result['projection'] = implode(',', $result['projection']);
        }
        if (isset($result['groupFilter']) && !empty($result['groupFilter'])) {
            $result['groupFilter'] = implode(',', $result['groupFilter']);
        }

        return $result;
    }
}

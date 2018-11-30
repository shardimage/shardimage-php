<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models;

use shardimage\shardimagephpapi\base\BaseObject;

abstract class IndexParams extends BaseObject
{

    /**
     * @var integer number of rows per page
     */
    public $maxResults;

    /**
     * @var string ordering the result
     */
    public $order;

    /**
     * @var integer|string|bool In request, the page we want to query.
     * In response, the token for the next page, if exist. If not, false.
     */
    public $nextPageToken;

    /**
     * @var array projection to manipulate the query
     */
    public $projection = [];

    /**
     * 
     */
    public function toArray($excludeEmpty = false)
    {
        $result = parent::toArray($excludeEmpty);
        if (isset($result['projection']) && !empty($result['projection'])) {
            $result['projection'] = implode(',', $result['projection']);
        }

        return $result;
    }
}

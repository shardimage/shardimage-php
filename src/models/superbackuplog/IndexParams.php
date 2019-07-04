<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackuplog;

use shardimage\shardimagephp\models\IndexParams as BaseIndexParams;

class IndexParams extends BaseIndexParams
{

    const FILTER_ONLY_SUCCESS = 'onlySuccess';
    const FILTER_ONLY_ERROR = 'onlyError';
    const FILTER_ONLY_UPLOAD = 'onlyUpload';
    const FILTER_ONLY_DELETE = 'onlyDelete';

    /**
     * @var array
     */
    public $filters = [];

}

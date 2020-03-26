<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2020 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\upload;

class UploadParams
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $optionalParams;

    /**
     * @param array $params
     * @param array $optionalParams
     */
    public function __construct(array $params, array $optionalParams = [])
    {
        $this->params = $params;
        $this->optionalParams = $optionalParams;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getOptionalParams(): array
    {
        return $this->optionalParams;
    }
}

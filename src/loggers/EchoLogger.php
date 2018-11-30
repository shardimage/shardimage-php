<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\loggers;

class EchoLogger extends BaseLogger
{
    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        echo $this->interpolate($message, $context) . "\n";
    }
}

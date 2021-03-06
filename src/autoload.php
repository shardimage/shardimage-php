<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

spl_autoload_register(function ($class) {
    $parts = explode('\\', ltrim($class, '\\'));
    if ($parts[0] == 'shardimage' && ($parts[1] == 'shardimagephp')) {
        include __DIR__.'/'.implode('/', array_slice($parts, 2)).'.php';
    }
}, true, true);

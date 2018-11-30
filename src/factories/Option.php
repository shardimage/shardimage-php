<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

class Option
{
    const CACHE_PUBLIC = 'public';
    const CACHE_PRIVATE = 'private';
    const CACHE_NO_CACHE = 'no-cache';

    /**
     * @var array
     */
    private $items = [];

    public function cache($cache)
    {
        return $this->addItem('hc-cacheability', $cache);
    }

    public function cacheMaxAge($interval)
    {
        return $this->addItem('hc-maxage', $interval);
    }

    public function cacheMinFresh($interval)
    {
        return $this->addItem('hc-minfresh', $interval);
    }

    public function cacheSharedMaxAge($interval)
    {
        return $this->addItem('hc-s-maxage', $interval);
    }

    /**
     * Add expirity timestamp to URL
     * @param integer $expire
     */
    public function urlExpire($expire)
    {
        return $this->addItem('url-exp', $expire);
    }

    /**
     * Add download option to URL
     */
    public function download()
    {
        return $this->addItem('download');
    }

    /**
     * Adds a new property item.
     *
     * @return \self
     */
    private function addItem()
    {
        $args = func_get_args();
        $this->items[$args[0]] = implode(':', $args);

        return $this;
    }

    /**
     * Renders the text URL string.
     *
     * @return string
     */
    private function render()
    {
        return implode('_', $this->items);
    }

    /**
     * Magic method for string casting.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}

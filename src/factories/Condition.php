<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

class Condition
{
    const INIT_WIDTH = 'iw';
    const INIT_HEIGHT = 'ih';
    const WIDTH = 'iw';
    const HEIGHT = 'ih';
    const PAGE_COUNT = 'pc';
    const FACE_COUNT = 'fc';
    const BODY_COUNT = 'bc';
    const EYE_COUNT = 'ec';
    const ASPECT_RATIO = 'ar';

    /**
     * @var array Text properties
     */
    private $items = [];

    public function eq($operand, $value)
    {
        return $this->addItem($operand, 'eq', $value);
    }

    public function ne($operand, $value)
    {
        return $this->addItem($operand, 'ne', $value);
    }

    public function lt($operand, $value)
    {
        return $this->addItem($operand, 'lt', $value);
    }

    public function gt($operand, $value)
    {
        return $this->addItem($operand, 'gt', $value);
    }

    public function lte($operand, $value)
    {
        return $this->addItem($operand, 'lte', $value);
    }

    public function gte($operand, $value)
    {
        return $this->addItem($operand, 'gte', $value);
    }

    public function a()
    {
        return $this->addItem('and');
    }

    public function o()
    {
        return $this->addItem('or');
    }

    /**
     * Adds a new property item.
     *
     * @return \self
     */
    private function addItem()
    {
        $this->items[] = implode(',', func_get_args());

        return $this;
    }

    /**
     * Renders the text URL string.
     *
     * @return string
     */
    private function render()
    {
        return implode('_', $this->parts);
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

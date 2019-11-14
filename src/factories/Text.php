<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

class Text
{
    /**
     * Thin font weight.
     */
    const WEIGHT_THIN = 'thin';

    /**
     * Light font weight.
     */
    const WEIGHT_LIGHT = 'light';

    /**
     * Normal font weight.
     */
    const WEIGHT_NORMAL = 'normal';

    /**
     * Medium font weight.
     */
    const WEIGHT_MEDIUM = 'medium';

    /**
     * Bold font weight.
     */
    const WEIGHT_BOLD = 'bold';

    /**
     * Black font weight.
     */
    const WEIGHT_BLACK = 'black';

    /**
     * 100 font weight.
     */
    const WEIGHT_W100 = 'w100';

    /**
     * 200 font weight.
     */
    const WEIGHT_W200 = 'w200';

    /**
     * 300 font weight.
     */
    const WEIGHT_W300 = 'w300';

    /**
     * 400 font weight.
     */
    const WEIGHT_W400 = 'w400';

    /**
     * 500 font weight.
     */
    const WEIGHT_W500 = 'w500';

    /**
     * 600 font weight.
     */
    const WEIGHT_W600 = 'w600';

    /**
     * 700 font weight.
     */
    const WEIGHT_W700 = 'w700';

    /**
     * 800 font weight.
     */
    const WEIGHT_W800 = 'w800';

    /**
     * 900 font weight.
     */
    const WEIGHT_W900 = 'w900';

    /**
     * Underline text decoration.
     */
    const DECORATION_UNDERLINE = 'unl';

    /**
     * Overline text decoration.
     */
    const DECORATION_OVERLINE = 'ovl';

    /**
     * Strikethrough text decoration.
     */
    const DECORATION_STRIKETHROUGH = 'str';

    /**
     * Italic text style.
     */
    const STYLE_ITALIC = 'italic';

    /**
     * Oblique text style.
     */
    const STYLE_OBLIQUE = 'oblique';

    /**
     * Left text alignment.
     */
    const ALIGN_LEFT = 'left';

    /**
     * Right text alignment.
     */
    const ALIGN_RIGHT = 'right';

    /**
     * Center text alignment.
     */
    const ALIGN_CENTER = 'center';

    /**
     * Text alignment to the start.
     */
    const ALIGN_START = 'start';

    /**
     * Text alignment to the end.
     */
    const ALIGN_END = 'end';

    /**
     * Text fonts
     */
    const FONT_ACLONICA = 'aclonica';
    const FONT_DROIDSANS = 'droidsans';
    const FONT_EXO = 'exo';
    const FONT_JUSTANOTHERHAND = 'justanotherhand';
    const FONT_MONTEZ = 'montez';
    const FONT_OPENSANS = 'opensans';
    const FONT_ROBOTO = 'roboto';
    const FONT_TINOS = 'tinos';
    const FONT_YELLOWTAIL = 'yellowtail';
    const FONT_XIAOWEI = 'xiaowei';
    const FONT_KUHEI = 'kuhei';
    const FONT_SHEKARI = 'shekari';

    /**
     * @var array Text properties
     */
    private $items = [];

    /**
     * @var string Text
     */
    private $text;

    /**
     * Creates a new Text object.
     *
     * @param string $text Text
     *
     * @return \self
     */
    public static function create($text)
    {
        $object = new self();
        $object->text = $text;

        return $object;
    }

    /**
     * Sets the font family.
     *
     * @param string $font Font family.
     *
     * @return \self
     */
    public function font($font)
    {
        return $this->addItem('font', $font);
    }

    /**
     * Sets the font weight.
     *
     * @param string $weight Font weight
     *                       <br>
     *                       <li>"normal"
     *                       <li>"bold"
     *
     * @return \self
     */
    public function weight($weight)
    {
        return $this->addItem('weight', $weight);
    }

    /**
     * Sets the text decoration.
     *
     * @param string $decoration Text decoration
     *                           <br>
     *                           <li>"underline"
     *                           <li>"overline"
     *                           <li>"strike"
     *
     * @return \self
     */
    public function decoration($decoration)
    {
        return $this->addItem('decoration', $decoration);
    }

    /**
     * Sets the text style.
     *
     * @param string $style Text style
     *                      <br>
     *                      <li>"italic"
     *                      <li>"oblique"
     *
     * @return \self
     */
    public function style($style)
    {
        return $this->addItem('style', $style);
    }

    /**
     * Sets the font size.
     *
     * @param int $size Font size in pixels
     *
     * @return \self
     */
    public function size($size)
    {
        return $this->addItem('size', 's', $size);
    }

    /**
     * Sets the stroke color.
     *
     * @param string $color Color in CSS format
     *
     * @return \self
     */
    public function strokeColor($color)
    {
        return $this->addItem('strokeColor', 'sc', $color);
    }

    /**
     * Sets the stroke width.
     *
     * @param int $width Width in pixels
     *
     * @return \self
     */
    public function strokeWidth($width)
    {
        return $this->addItem('strokeWidth', 'sw', $width);
    }

    /**
     * Sets the text alignment.
     *
     * @param string $align Text alignment.
     *                      <br>
     *                      <li>"left"
     *                      <li>"center"
     *                      <li>"right"
     *                      <li>"start"
     *                      <li>"end"
     *
     * @return \self
     */
    public function align($align)
    {
        return $this->addItem('align', $align);
    }

    /**
     * Turns on text wrapping.
     *
     * @return \self
     */
    public function wrap()
    {
        return $this->addItem('wrap', 'wrap');
    }

    /**
     * Turns on base64 encoding for the text.
     *
     * @return \self
     */
    public function base64()
    {
        return $this->addItem('base64', 'b64');
    }

    /**
     * Adds a new property item.
     *
     * @return \self
     */
    private function addItem()
    {
        $args = func_get_args();
        $this->items[$args[0]] = implode(':', array_slice($args, 1));

        return $this;
    }

    /**
     * Renders the text URL string.
     *
     * @return string
     */
    private function render()
    {
        $parts = [];
        if (!empty($this->items)) {
            $parts[] = implode(',', $this->items);
        } else {
            $this->text = ':' . $this->text;
        }
        $parts[] = isset($this->items['base64']) ? self::base64Encode($this->text) : rawurlencode($this->text);

        return implode(':', $parts);
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

    /**
     * Custom base64 encoding.
     *
     * @param string $string Text
     *
     * @return string
     */
    private static function base64Encode($string)
    {
        return str_replace(['/', '+'], ['_', '-'], rtrim(base64_encode($string), '='));
    }
}

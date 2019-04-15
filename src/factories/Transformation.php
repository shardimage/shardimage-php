<?php

/**
 * @see https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

class Transformation
{
    private $items = [];
    private $itemCount = 0;
    private static $appendableTransformations = ['g', 'flag'];
    private static $forcedLastTransformations = ['l'];

    /**
     * Creates a new transformation object.
     *
     * @return \self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Adds a new transformation group.
     *
     * Groups are executed in the given order, while items in groups are
     * executed in optimized order.
     *
     * @return \self
     */
    public function group()
    {
        return $this->addItem('/');
    }

    /**
     * Rotates the image clockwise by the specicifed degrees.
     *
     * @param float $degrees Degrees
     *
     * @return self
     */
    public function rotateCW($degrees)
    {
        return $this->addItem('r', $degrees);
    }

    /**
     * Rotates the image counterclockwise by the specicifed degrees.
     *
     * @param float $degrees Degrees
     *
     * @return \self
     */
    public function rotateCCW($degrees)
    {
        return $this->addItem('r', 360 - $degrees);
    }

    /**
     * Sets the target width.
     *
     * @param int $width Width
     *
     * @return \self
     */
    public function width($width)
    {
        return $this->addItem('w', $width);
    }

    /**
     * Sets the target height.
     *
     * @param int $height Height
     *
     * @return \self
     */
    public function height($height)
    {
        return $this->addItem('h', $height);
    }

    /**
     * Resizes the image to the specified width and height.
     *
     * @param int $size Width and height
     *
     * @return \self
     */
    public function size($size)
    {
        return $this->addItem('wh', $size);
    }

    /**
     * Sets the X offset to the specified value.
     *
     * @param int $offset X offset
     *
     * @return \self
     */
    public function x($offset)
    {
        return $this->addItem('x', $offset);
    }

    /**
     * Sets the Y offset to the specified value.
     *
     * @param int $offset Y offset
     *
     * @return \self
     */
    public function y($offset)
    {
        return $this->addItem('y', $offset);
    }

    /**
     * Crops the image to the exact size specified by the resize methods.
     *
     * @return \self
     */
    public function crop()
    {
        return $this->addItem('c', 'crop');
    }

    /**
     * Scales the image, not maintaining aspect ratio.
     *
     * @return \self
     */
    public function scale()
    {
        return $this->addItem('c', 'sc');
    }

    /**
     * Fits the image into a box specified by the resize methods by adjusting
     * the larger proportion.
     *
     * @return \self
     */
    public function fit()
    {
        return $this->addItem('c', 'fit');
    }

    /**
     * Fits the image into a box specified by the resize methods, but only if
     * the original image is larger than the box.
     *
     * @return \self
     */
    public function lFit()
    {
        return $this->addItem('c', 'lfit');
    }

    /**
     * Fits the image into a box specified by the resize methods and adds
     * padding with the background color, if the size of the fitted image is
     * not exactly the same as the size of the box.
     *
     * @return \self
     */
    public function pad()
    {
        return $this->addItem('c', 'pad');
    }

    /**
     * Fits the image into a box specified by the resize methods, but only if
     * the original image is larger than the box and adds padding with the
     * background color, if the size of the fitted image is not exactly the same
     * as the size of the box.
     *
     * @return \self
     */
    public function lPad()
    {
        return $this->addItem('c', 'lp');
    }

    /**
     * Fits the image using gravity.
     *
     * @return \self
     */
    public function fill()
    {
        return $this->addItem('c', 'fill');
    }

    /**
     * Fits the image using gravity, but only if the original image is
     * larger than the box.
     *
     * @return \self
     */
    public function lFill()
    {
        return $this->addItem('c', 'lfill');
    }

    /**
     * Trims the image by the specified fuzzy color threshold.
     *
     * @param int $fuzzy Fuzzy color threshold
     *
     * @return \self
     */
    public function trim($fuzzy = 30)
    {
        return $this->addItem('c', 'trim', $fuzzy);
    }

    /**
     * Zooms the image by the specified percentage.
     *
     * @param int $percent Zoom percentage
     *
     * @return \self
     */
    public function zoom($percent)
    {
        return $this->addItem('z', $percent);
    }

    /**
     * Places a layer over the current image.
     *
     * @param string $publicId
     *
     * @return \self
     */
    public function overlay($publicId)
    {
        return $this->addItem('l', 'lo', rawurlencode(rawurlencode($publicId)));
    }

    /**
     * Places a layer under the current image.
     *
     * @param string $publicId
     *
     * @return \self
     */
    public function underlay($publicId)
    {
        return $this->addItem('l', 'lu', rawurlencode(rawurlencode($publicId)));
    }

    /**
     * @param string|Text $text
     *
     * @return \self
     */
    public function textOverlay($text)
    {
        return $this->addItem('l', 'otext', (string) $text);
    }

    /**
     * @param string|Text $text
     *
     * @return \self
     */
    public function textUnderlay($text)
    {
        return $this->addItem('l', 'utext', (string) $text);
    }

    /**
     * Closes the layer definition.
     *
     * @return \self
     */
    public function end()
    {
        return $this->group()->addItem('l', 'end')->group();
    }

    /**
     * Sets the density of pixels.
     *
     * @param float $density Density in DPI
     *
     * @return \self
     */
    public function density($density)
    {
        return $this->addItem('dn', $density);
    }

    public function ifIf($condition)
    {
        return $this->addItem('if('.$condition.')');
    }

    public function ifElseIf($condition)
    {
        return $this->addItem('if', 'elseif('.$condition.')');
    }

    public function ifElse()
    {
        return $this->addItem('if', 'else');
    }

    public function ifEnd()
    {
        return $this->addItem('if', 'end');
    }

    /**
     * @return \self
     */
    public function gFaces()
    {
        return $this->addItem('g', 'faces');
    }

    /**
     * @return \self
     */
    public function gFace($id = null)
    {
        return $id === null ? $this->addItem('g', 'face') : $this->addItem('g', 'face', $id);
    }

    /**
     * @return \self
     */
    public function gEyes()
    {
        return $this->addItem('g', 'eyes');
    }

    /**
     * @return \self
     */
    public function gTopLeft()
    {
        return $this->addItem('g', 'tl');
    }

    /**
     * @return \self
     */
    public function gTopRight()
    {
        return $this->addItem('g', 'tr');
    }

    /**
     * @return \self
     */
    public function gBottomLeft()
    {
        return $this->addItem('g', 'bl');
    }

    /**
     * @return \self
     */
    public function gBottomRight()
    {
        return $this->addItem('g', 'br');
    }

    /**
     * @return \self
     */
    public function gTop()
    {
        return $this->addItem('g', 't');
    }

    /**
     * @return \self
     */
    public function gBottom()
    {
        return $this->addItem('g', 'b');
    }

    /**
     * @return \self
     */
    public function gLeft()
    {
        return $this->addItem('g', 'l');
    }

    /**
     * @return \self
     */
    public function gRight()
    {
        return $this->addItem('g', 'r');
    }

    /**
     * @return \self
     */
    public function gCenter()
    {
        return $this->addItem('g', 'center');
    }

    /**
     * @return \self
     */
    public function gXYCenter()
    {
        return $this->addItem('g', 'xy-center');
    }

    /**
     * @return \self
     */
    public function threshold()
    {
        return $this->addItem('e', 'th');
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function blur($amount)
    {
        return $this->addItem('e', 'blur', $amount);
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function tintBlue($amount)
    {
        return $this->addItem('e', 'blue', $amount);
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function tintGreen($amount)
    {
        return $this->addItem('e', 'green', $amount);
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function tintRed($amount)
    {
        return $this->addItem('e', 'red', $amount);
    }

    /**
     * @return \self
     */
    public function brightness($amount)
    {
        return $this->addItem('e', 'brightness', $amount);
    }

    /**
     * @return \self
     */
    public function grayscale()
    {
        return $this->addItem('e', 'grayscale');
    }

    /**
     * @return \self
     */
    public function greyscale()
    {
        return $this->grayscale();
    }

    /**
     * @return \self
     */
    public function hue($degrees)
    {
        return $this->addItem('e', 'hue', $degrees);
    }

    /**
     * @return \self
     */
    public function negative()
    {
        return $this->addItem('e', 'inv');
    }

    /**
     * @return \self
     */
    public function invert()
    {
        return $this->negative();
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function opacity($amount)
    {
        return $this->addItem('e', 'o', $amount);
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function pixelate($amount)
    {
        return $this->addItem('e', 'px', $amount);
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function sepia($amount)
    {
        return $this->addItem('e', 'sepia', $amount);
    }

    /**
     * @param type $amount
     *
     * @return \self
     */
    public function sharpen($amount)
    {
        return $this->addItem('e', 'sharpen', $amount);
    }

    /**
     * @param int $radius
     *
     * @return \self
     */
    public function oilPaint($radius)
    {
        return $this->addItem('e', 'oil-paint', $radius);
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return \self
     */
    public function shear($x, $y = null)
    {
        return $this->addItem('e', 'shear', isset($y) ? implode(',', [$x, $y]) : $x);
    }

    /**
     * Add perspective transformation.
     *
     * @param int $dx1 destination x1
     * @param int $dy1 destination y1
     * @param int $dx2 destination x2
     * @param int $dy2 destination y2
     * @param int $dx3 destination x3
     * @param int $dy3 destination y3
     * @param int $dx4 destination x4
     * @param int $dy4 destination y4
     * @param int $sx1 source x1
     * @param int $sy1 source y1
     * @param int $sx2 source x2
     * @param int $sy2 source y2
     * @param int $sx3 source x3
     * @param int $sy3 source y3
     * @param int $sx4 source x4
     * @param int $sy4 source y4
     *
     * @return \self
     */
    public function perspective($dx1, $dy1, $dx2, $dy2, $dx3, $dy3, $dx4, $dy4, $sx1 = null, $sy1 = null, $sx2 = null, $sy2 = null, $sx3 = null, $sy3 = null, $sx4 = null, $sy4 = null)
    {
        if (!is_null($sx1) || !is_null($sy1) || !is_null($sx2) || !is_null($sy2) || !is_null($sx3) || !is_null($sy3) || !is_null($sx4) || !is_null($sy4)) {
            $params = [$sx1, $sy1, $dx1, $dy1, $sx2, $sy2, $dx2, $dy2, $sx3, $sy3, $dx3, $dy3, $sx4, $sy4, $dx4, $dy4];
        } else {
            $params = [$dx1, $dy1, $dx2, $dy2, $dx3, $dy3, $dx4, $dy4];
        }
        return $this->addItem('e', 'perspective', implode(',', $params));
    }

    /**
     * @param type $color
     *
     * @return \self
     */
    public function background($color)
    {
        return $this->addItem('bg', $color);
    }

    /**
     * @param type $color
     *
     * @return \self
     */
    public function color($color)
    {
        return $this->addItem('co', $color);
    }

    /**
     * Applies a border to the image.
     *
     * Use <b>color()</b> to specify the color of the border.
     *
     * Parameters behave like CSS border sizes, the number of given
     * parameters modifies the function behaviour.
     *
     * <li>If 1 parameter is given, all borders have the same size.
     * <li>If 2 parameters are given, the parameters are interpreted as vertical and
     * horizontal borders.
     * <li>If 3 parameters are given, the parameters are interpreted as top,
     * vertical and bottom borders.
     * <li>If 4 parameters are given, all borders have their respective sizes.
     *
     * @param int $top    All/vertical/top border size
     * @param int $right  Horizontal/right border size
     * @param int $bottom Bottom border size
     * @param int $left   Left border size
     *
     * @return \self
     */
    public function border($top, $right = null, $bottom = null, $left = null)
    {
        return $this->addItem('border', implode(',', func_get_args()));
    }

    /**
     * Rounds the corners of the image.
     *
     * Parameters behave like CSS border radiuses, the number of given
     * parameters modifies the function behaviour. Either 1 or 4 parameters
     * are required.
     *
     * <li>If 1 parameter is given, all corners are rounded with the same
     * radius.
     * <li>If 4 parameters are given, corners are rounded with their respective
     * radiuses.
     *
     * @param type $topLeft     General radius or radius on the top left corner
     * @param type $topRight    Radius on the top right corner
     * @param type $bottomRight Radius on the bottom right corner
     * @param type $bottomLeft  Radius on the bottom left corner
     *
     * @return \self
     */
    public function round($topLeft, $topRight = null, $bottomRight = null, $bottomLeft = null)
    {
        return $this->addItem('ro', implode(',', func_get_args()));
    }

    /**
     * Rounds the corners of the image with the maximum possible radius.
     *
     * @return \self
     */
    public function roundMax()
    {
        return $this->round('max');
    }

    /**
     * Flips the image vertically.
     *
     * @return \self
     */
    public function flipVertical()
    {
        return $this->addItem('flip', 'v');
    }

    /**
     * Flips the image horizontally.
     *
     * @return \self
     */
    public function flipHorizontal()
    {
        return $this->addItem('flip', 'h');
    }

    /**
     * Flips the image horizontally and vertically.
     *
     * @return \self
     */
    public function flipHorizontalAndVertical()
    {
        return $this->addItem('flip', 'vh');
    }

    /**
     * Flips the image horizontally and vertically.
     *
     * @return \self
     */
    public function flipVerticalAndHorizontal()
    {
        return $this->flipHorizontalAndVertical();
    }

    /**
     * Sets the video delay.
     *
     * @param int $time Delay between the frames in ms
     *
     * @return \self
     */
    public function delay($time)
    {
        return $this->addItem('delay', $time);
    }

    /**
     * Sets the image quality.
     *
     * @param int $quality quality in percent
     *
     * @return \self
     */
    public function quality($quality)
    {
        return $this->addItem('q', $quality);
    }

    /**
     * Turns on jpegoptim, which greatly reduces the size of jpeg images.
     *
     * @param int $quality maximum quality
     *
     * @return \self
     */
    public function jpegoptim($quality = null)
    {
        return $quality === null ? $this->addItem('q', 'jpegoptim') : $this->addItem('q', 'jpegoptim', $quality);
    }

    /**
     * Turns on OptiPNG, which greatly reduces the size of png images.
     *
     * @return \self
     */
    public function optipng()
    {
        return $this->addItem('q', 'optipng');
    }

    /**
     * Sets a general flag.
     *
     * @param string $flag
     *
     * @return \self
     */
    public function flag($flag)
    {
        return $this->addItem('flag', $flag);
    }

    /**
     * Forces the engine not to use the orientate flag (e.g. in jpegs). Images
     * are not going to be rotated automatically according to the exif data.
     *
     * @return \self
     */
    public function noOrientate()
    {
        return $this->flag('not-orientate');
    }

    /**
     * Empty operation.
     *
     * @return \self
     */
    public function nop()
    {
        return $this->addItem('nop');
    }

    /**
     * Sets the format to jpg.
     *
     * @return \self
     */
    public function toJpg()
    {
        return $this->addItem('format', 'jpg');
    }

    /**
     * Sets the format to jpeg.
     *
     * @return \self
     */
    public function toJpeg()
    {
        return $this->addItem('format', 'jpeg');
    }

    /**
     * Sets the format to bmp.
     *
     * @return \self
     */
    public function toBmp()
    {
        return $this->addItem('format', 'bmp');
    }

    /**
     * Sets the format to gif.
     *
     * @return \self
     */
    public function toGif()
    {
        return $this->addItem('format', 'gif');
    }

    /**
     * Sets the format to png.
     *
     * @return \self
     */
    public function toPng()
    {
        return $this->addItem('format', 'png');
    }

    /**
     * Sets the format to png8.
     *
     * @return \self
     */
    public function toPng8()
    {
        return $this->addItem('format', 'png8');
    }

    /**
     * Sets the format to png24.
     *
     * @return \self
     */
    public function toPng24()
    {
        return $this->addItem('format', 'png24');
    }

    /**
     * Sets the format to png32.
     *
     * @return \self
     */
    public function toPng32()
    {
        return $this->addItem('format', 'png32');
    }

    /**
     * Sets the format to png48.
     *
     * @return \self
     */
    public function toPng48()
    {
        return $this->addItem('format', 'png48');
    }

    /**
     * Sets the format to png64.
     *
     * @return \self
     */
    public function toPng64()
    {
        return $this->addItem('format', 'png64');
    }

    /**
     * Sets the format to webp.
     *
     * @param bool $lossless Lossless or lossy compression
     *
     * @return \self
     */
    public function toWebp($lossless = true)
    {
        return $lossless ? $this->addItem('format', 'webp-lossless') : $this->addItem('format', 'webp');
    }

    /**
     * Sets the format to webm.
     *
     * @return \self
     */
    public function toWebm()
    {
        return $this->addItem('format', 'webm');
    }

    /**
     * Sets the format to tiff.
     *
     * @return \self
     */
    public function toTiff()
    {
        return $this->addItem('format', 'tiff');
    }

    /**
     * Sets the given format.
     *
     * @param string $format
     *
     * @return \self
     */
    public function toFormat($format)
    {
        return $this->addItem('format', $format);
    }

    /**
     * Sets the given parameter item into the chain.
     *
     * @param string $parameter
     *
     * @return \self
     */
    public function addRaw($parameter)
    {
        return $this->addItem($parameter);
    }

    /**
     * Adds a new transformation item to the chain.
     *
     * @return \self
     */
    private function addItem()
    {
        $args = func_get_args();
        if (in_array($args[0], self::$appendableTransformations)) {
            $i = $this->findLastTransformation($args[0]);
            if ($i !== false) {
                $this->items[$i]['rendered'] .= ','.implode(':', array_slice($args, 1));

                return $this;
            }
        }
        if ($args[0] != '/' && $this->itemCount && in_array($this->items[$this->itemCount - 1]['type'], self::$forcedLastTransformations)) {
            $lastTransformation = array_pop($this->items);
        }
        $this->items[] = [
            'type' => $args[0],
            'rendered' => implode(':', $args),
        ];
        ++$this->itemCount;
        if (isset($lastTransformation)) {
            $this->items[] = $lastTransformation;
        }

        return $this;
    }

    private function findLastTransformation($type)
    {
        $i = $this->itemCount - 1;
        while ($i >= 0 && $this->items[$i]['type'] != '/') {
            if ($this->items[$i]['type'] == $type) {
                return $i;
            }
            --$i;
        }

        return false;
    }

    /**
     * Renders the transformation URL string.
     *
     * @return string
     */
    private function render()
    {
        $transformation = implode('_', array_column($this->items, 'rendered'));
        $transformation = preg_replace('#(_?/_?)+#isu', '/', $transformation);
        $transformation = trim($transformation, '/_');

        return $transformation;
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

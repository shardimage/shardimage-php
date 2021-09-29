<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

use shardimage\shardimagephp\factories\Text;

class TextTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Get a new instance of a Text object.
     * @return Transformation
     */
    protected function getEmptyTextObject($text)
    {
        return Text::create($text);
    }

    public function testStringConvertion()
    {
        $text = ($this->getEmptyTextObject('Random text'));
        $this->assertInternalType('string', (string) $text);
    }

    public function testTextTransformations()
    {
        $expectedText = 'bold,s:40:The%20crowd%20is%20loud%21';
        $text = ($this->getEmptyTextObject('The crowd is loud!'))->weight(Text::WEIGHT_BOLD)->size(40);
        $this->assertEquals($expectedText, (string) $text);
    }

    public function testAdvancedTextTransformations()
    {
        $expectedText = 'bold,wrap,montez,s:40:The%20crowd%20is%20loud%21';
        $text = ($this->getEmptyTextObject('The crowd is loud!'))->weight(Text::WEIGHT_BOLD)->wrap()->font(Text::FONT_MONTEZ)->size(40);
        $this->assertEquals($expectedText, (string) $text);
    }

    public function testTextEncoding()
    {
        $expectedText = 's:40,b64:' . str_replace('==', '', base64_encode('My encoded text.'));
        $text = ($this->getEmptyTextObject('My encoded text.'))->size(40)->base64();
        $this->assertEquals($expectedText, (string) $text);
    }

    public function testSpace()
    {
        $expectedText = 'ws:40:The%20crowd%20is%20loud%21';
        $text = ($this->getEmptyTextObject('The crowd is loud!'))->space(40);
        $this->assertSame($expectedText, (string) $text);
    }

    public function testLineSpace()
    {
        $expectedText = 'lines:50:The%20crowd%20is%20loud%21';
        $text = ($this->getEmptyTextObject('The crowd is loud!'))->lineSpace(50);
        $this->assertSame($expectedText, (string) $text);
    }

    public function testGoogleFonts()
    {
        $expectedMontserratText = 'gf:Montserrat:The%20crowd%20is%20loud%21';
        $montserratText = ($this->getEmptyTextObject('The crowd is loud!'))->googleFonts('Montserrat');
        $this->assertSame($expectedMontserratText, (string) $montserratText);
        $expectedBadScriptText = 'gf:Bad%20Script:The%20crowd%20is%20loud%21';
        $badScriptText = ($this->getEmptyTextObject('The crowd is loud!'))->googleFonts('Bad Script');
        $this->assertSame($expectedBadScriptText, (string) $badScriptText);
    }

    public function testDefaultNopTransformation()
    {
        $expectedText = 'nop:random';
        $simpleText = $this->getEmptyTextObject('random');
        $this->assertSame($expectedText, (string) $simpleText);
    }
}

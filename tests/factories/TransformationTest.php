<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

use shardimage\shardimagephp\factories\Condition;
use shardimage\shardimagephp\factories\Transformation;

class TransformationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Get a new instance of a Transformation object.
     * @return Transformation
     */
    protected function getEmptyTransformationObject()
    {
        return new Transformation();
    }

    public function testStringConvertion()
    {
        $transformation = ($this->getEmptyTransformationObject())->width(500)->toPng32();
        $this->assertInternalType('string', (string) $transformation);
    }

    public function testCustomTransformation()
    {
        $expectedTransformation = "customTr:50_wh:20_other";
        $transformation = ($this->getEmptyTransformationObject())->addRaw('customTr:50')->size(20)->addRaw('other');
        $this->assertEquals($expectedTransformation, (string) $transformation);
    }

    public function testRezize()
    {
        $expectedTransformation = "wh:500";
        $transformation = ($this->getEmptyTransformationObject())->size(500);
        $this->assertEquals($expectedTransformation, (string) $transformation);
    }

    public function testFormat()
    {
        $expectedTransformation = "format:png8";
        $transformation = ($this->getEmptyTransformationObject())->toPng8();
        $this->assertEquals($expectedTransformation, (string) $transformation);
    }

    public function testConditions()
    {
        $expectedTransformation = "w:200/if(ar,lt,1.5)_border:0,4,0,4_co:red/if:else_border:4,0,4,0_co:black";
        $condition = (new Condition())->lt(Condition::ASPECT_RATIO, 1.5);
        $transformation = ($this->getEmptyTransformationObject())
                ->width(200)
                ->group()->ifIf($condition)->border(0, 4, 0, 4)->color('red')
                ->group()->ifElse()->border(4, 0, 4, 0)->color('black');
        $this->assertEquals($expectedTransformation, (string) $transformation);
    }
}
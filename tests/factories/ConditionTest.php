<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

use shardimage\shardimagephp\factories\Condition;

class ConditionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Get a new instance of a Condition object.
     * @return Transformation
     */
    protected function getEmptyConditionObject()
    {
        return new Condition();
    }

    public function testStringConvertion()
    {
        $condition = ($this->getEmptyConditionObject())->gt(Condition::PAGE_COUNT, 5)->a()->lt(Condition::PAGE_COUNT, 20);
        $this->assertInternalType('string', (string) $condition);
    }

    public function testCondition()
    {
        $expectedCondition = 'pc,gt,5_and_pc,lt,20_or_fc,gt,20';
        $condition = ($this->getEmptyConditionObject())->gt(Condition::PAGE_COUNT, 5)->a()->lt(Condition::PAGE_COUNT, 20)->o()->gt(Condition::FACE_COUNT, 20);
        $this->assertEquals($expectedCondition, (string) $condition);
    }
}

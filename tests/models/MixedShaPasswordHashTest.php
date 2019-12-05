<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models;

use shardimage\shardimagephp\models\accesstoken\MixedShaPasswordHash;

class MixedShaPasswordHashTest extends \PHPUnit\Framework\TestCase
{

    public function testArrayConversion()
    {
        $passwordHash = new MixedShaPasswordHash('testPassword');
        $convertedPassword = $passwordHash->toArray();
        // expected to be array
        $this->assertInternalType('array', $passwordHash->toArray());
        // expected to have to element
        $this->assertSame(2, count($convertedPassword));
    }

    public function testConversionResult()
    {
        $passwordHash = new MixedShaPasswordHash('testPassword');
        $convertedPassword = $passwordHash->toArray();
        $encryptedPasswordString = '51f6b2576589a239f5b3bbe99bf2151eb3c84832';
        // expected conversion result
        $this->assertSame(40, strlen($encryptedPasswordString));
        $this->assertSame($encryptedPasswordString, $passwordHash->encrypt('testPassword'));
        $this->assertSame(['msha1', $encryptedPasswordString], $convertedPassword);
    }

}

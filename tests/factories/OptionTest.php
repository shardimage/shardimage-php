<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\factories;

use shardimage\shardimagephp\factories\Option;

class OptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Get a new instance of a Option object.
     * @return Transformation
     */
    protected function getEmptyOptionObject()
    {
        return new Option();
    }

    public function testStringConvertion()
    {
        $option = ($this->getEmptyOptionObject())->download()->strictSecureHash();
        $this->assertInternalType('string', (string) $option);
    }

    public function testCondition()
    {
        $expireTime = time() - 3600;
        $expectedOption = "url-exp:" . $expireTime . "_hc-maxage:3600_hc-cacheability:private_h:X-Custom-Header,Custom%20header%20value_strictSecureHash";
        $option = ($this->getEmptyOptionObject())->urlExpire($expireTime)->cacheMaxAge(3600)->cache(Option::CACHE_PRIVATE)->httpHeader('X-Custom-Header', 'Custom header value')->strictSecureHash();
        $this->assertEquals($expectedOption, (string) $option);
    }
}

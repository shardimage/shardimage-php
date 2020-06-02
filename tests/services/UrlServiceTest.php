<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\auth\Client;
use shardimage\shardimagephp\factories\Transformation;
use shardimage\shardimagephp\services\UrlService;
use shardimage\shardimagephpapi\base\exceptions\InvalidValueException;

class UrlServiceTest extends \PHPUnit\Framework\TestCase
{

    public function testUrlLimit()
    {
        $this->expectException(InvalidValueException::class);
        $service = new UrlService(new Client([
            'urlSizeLimit' => 0,
            'useMsgPack' => false,
        ]));
        $service->create(['cloudId' => 'example', 'publicId' => 'exampleImage']);
    }

    public function testUrlLimitWithTransformation()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessageRegExp('/^URL size exceeded the limit!/');
        $service = new UrlService(new Client([
            'urlSizeLimit' => 1.5,
            'useMsgPack' => false,
        ]));
        $transformation = new Transformation();
        for ($i = 0; $i < 100; $i++) {
            $transformation->group()->gTopLeft()->color('blue')->textOverlay('testText' . $i)->group();
        }
        $service->create(['cloudId' => 'example', 'publicId' => 'exampleImage'], ['transformation' => $transformation]);
    }

}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2020 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\builders;

use shardimage\shardimagephp\builders\UploadBuilder;

class UploadBuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Get a new instance of a UploadBuilder object.
     * @return UploadBuilder
     */
    protected function getEmptyBuilderObject()
    {
        return new UploadBuilder();
    }

    public function testEmptyBuilderReturn()
    {
        $builder = $this->getEmptyBuilderObject();
        $params = $builder->build();
        $this->assertTrue(is_object($params));
        $this->assertSame([], $params->getParams());
        $this->assertSame([], $params->getOptionalParams());
    }

    public function testAddPublicId()
    {
        $publicId = 'testPublicId' . md5(time());
        /** @var UploadBuilder $builder */
        $builder = ($this->getEmptyBuilderObject())->withPublicId($publicId);
        $params = $builder->build();
        $this->assertTrue(is_object($params));
        $this->assertSame(['publicId' => $publicId], $params->getParams());
        $this->assertSame([], $params->getOptionalParams());
    }

    public function testAddPublicIdWithPrefix()
    {
        $publicId = 'testPublicId' . md5(time());
        $prefix = 'shardimage-';
        /** @var UploadBuilder $builder */
        $builder = ($this->getEmptyBuilderObject())->withPublicId($publicId)->withPrefix($prefix);
        $params = $builder->build();
        $this->assertTrue(is_object($params));
        $this->assertSame(['publicId' => sprintf("%s%s", $prefix, $publicId)], $params->getParams());
        $this->assertSame([], $params->getOptionalParams());
    }
    
    public function testAddTags()
    {
        $tags = ['one', 'two'];
        $additionalTags = ['three'];
        $builder = ($this->getEmptyBuilderObject())->withTags($tags)->withAddedTags($additionalTags);
        $params = $builder->build();
        $this->assertTrue(is_object($params));
        $this->assertSame([], $params->getParams());
        $this->assertSame(['tags' => array_merge($tags, $additionalTags)], $params->getOptionalParams());
        $newParams = $builder->withoutTags()->build();
        $this->assertTrue(is_object($newParams));
        $this->assertSame([], $newParams->getParams());
        $this->assertSame(['tags' => []], $newParams->getOptionalParams());
    }

    public function testOverride()
    {
        $builder = ($this->getEmptyBuilderObject());
        $params = $builder->allowOverride()->build();
        $this->assertTrue(is_object($params));
        $this->assertSame(['allowOverride' => true], $params->getParams());
        $newParams = $builder->disallowOverride()->build();
        $this->assertTrue(is_object($newParams));
        $this->assertSame(['allowOverride' => false], $newParams->getParams());
    }
}

<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2020 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\builders;

use shardimage\shardimagephp\helpers\UploadHelper;
use shardimage\shardimagephp\models\upload\UploadParams;
use shardimage\shardimagephpapi\base\exceptions\InvalidParamException;

/**
 * Class UploadBuilder
 */
class UploadBuilder
{
    /**
     * @var string ID of cloud
     */
    private $cloudId;

    /**
     * @var resource - an opened file resource (@see fopen())
     */
    private $file;

    /**
     * @var string image remote resource
     */
    private $remoteResource;

    /**
     * @var string public image ID
     */
    private $publicId;

    /**
     * @var string prefix for public image ID
     */
    private $prefix = '';

    /**
     * @var array image tags
     */
    private $tags;

    /**
     * Set up cloud ID
     * @param string $cloudId
     * @return static
     */
    public function withCloudId(string $cloudId)
    {
        $new = clone $this;
        $new->cloudId = $cloudId;
        return $new;
    }

    /**
     * Set up file path
     * @param string $path
     * @return static
     * @throws InvalidParamException
     */
    public function withFilePath(string $path)
    {
        if (!file_exists($path)) {
            throw new InvalidParamException('Given path is not az existing file!');
        }
        return $this->withFileResource(fopen($path, 'r'));
    }

    /**
     * Set up file content
     * @param string $content
     * @return static
     * @throws InvalidParamException
     */
    public function withFileContent(string $content)
    {
        if (strlen($content) < 1) {
            throw new InvalidParamException('Given content must to be at least 1 character long!');
        }
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $content);
        rewind($stream);
        return $this->withFileResource($stream);
    }

    /**
     * Set up file resource for upload
     * @param resource $fileResource
     * @return static
     * @throws InvalidParamException
     */
    public function withFileResource($fileResource)
    {
        $new = clone $this;
        if (false === is_resource($fileResource)) {
            throw new InvalidParamException('Given file must to be resource!');
        }
        $new->remoteResource = null;
        $new->file = $fileResource;
        unset($fileResource);
        return $new;
    }

    /**
     * Set up resource for remote upload
     * @param string $resource
     * @return static
     */
    public function withRemoteResource(string $resource)
    {
        $new = clone $this;
        $new->remoteResource = $resource;
        $new->file = null;
        return $new;
    }

    /**
     * Set up prefix
     * @param string $prefix
     * @return static
     */
    public function withPrefix(string $prefix)
    {
        $new = clone $this;
        $new->prefix = $prefix;
        return $new;
    }

    /**
     * Set up public image ID
     * @param string $publicId
     * @param string|null $prefix
     * @return static
     */
    public function withPublicId(string $publicId)
    {
        $new = clone $this;
        $new->publicId = $publicId;
        return $new;
    }

    /**
     * Set up randomized public image ID
     * @param int $length
     * @param string|null $prefix
     * @return static
     */
    public function withRandomPublicId(int $length)
    {
        $new = clone $this;
        $new->publicId = UploadHelper::generateRandomPublicId($length);
        return $new;
    }

    /**
     * Set up tags
     * @param array $tags
     * @return static
     */
    public function withTags(array $tags)
    {
        $new = clone $this;
        $new->tags = $tags;
        return $new;
    }

    /**
     * Upload without tags
     * @return static
     */
    public function withoutTags()
    {
        $new = clone $this;
        $new->tags = [];
        return $new;
    }

    /**
     * Upload without tags
     * @return static
     */
    public function withAddedTags(array $tags)
    {
        $new = clone $this;
        $new->tags = array_merge($new->tags, $tags);
        return $new;
    }

    /**
     * @return UploadParams
     */
    public function build(): UploadParams
    {
        $params = [];
        $optionalParams = [];
        $this->addAttributeToParams($params, 'publicId', $this->buildPublicId());
        $this->addAttributeToParams($params, 'cloudId', $this->cloudId);
        $this->addAttributeToParams($params, 'resource', $this->remoteResource);
        $this->addAttributeToParams($params, 'file', $this->file);
        $this->addAttributeToParams($optionalParams, 'tags', $this->tags);
        return new UploadParams($params, $optionalParams);
    }

    /**
     * Add not null attributes to an array
     * @param array $params
     * @param string $key
     * @param mixed $attribute
     */
    private function addAttributeToParams(array &$params, string $key, $attribute = null)
    {
        if ($attribute !== null && $attribute !== '') {
            $params[$key] = $attribute;
        }
    }

    /**
     * Build up public image ID with prefix
     * @return string
     */
    private function buildPublicId(): string
    {
        return sprintf("%s%s", $this->prefix, $this->publicId);
    }
}
<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

use shardimage\shardimagephpapi\base\BaseObject;
use shardimage\shardimagephpapi\base\exceptions\InvalidConfigException;

/**
 * Implementing AccessToken
 *
 * @property-read string $type type of AccessToken usage
 */
abstract class AccessToken extends BaseObject
{
    /**
     * @var string ID of access token, can be used as `accessToken` in client configuration
     */
    public $id;

    /**
     * @var integer timestamp expiration of the access token
     */
    public $expiry;

    /**
     * @var integer request limits of the access token
     */
    public $limit;

    /**
     * @var mixed additional extras for the access token
     */
    public $extra;

    /**
     * @var integer timestamp of creation
     */
    public $createdAt;

    /**
     * @inheritDoc
     */
    public function __construct($config = [])
    {
        if (array_key_exists('type', $config) && $config['type'] !== $this->type) {
            throw new InvalidConfigException();
        }
        unset($config['type']);
        parent::__construct($config);
    }

    /**
     * Getting the type of access token
     */
    abstract public function getType();

    /**
     * @inheritdoc
     */
    protected function getToArrayAttributes()
    {
        return array_merge(parent::getToArrayAttributes(), ['type']);
    }

}

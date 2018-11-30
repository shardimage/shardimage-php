<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\data;

/**
 * Class Cdn.
 */
class Cdn extends BaseData
{
    const AKAMAI = 'AKAMAI';
    const CACHEFLY = 'CACHEFLY';
    const CLOUDFLARE = 'CLOUDFLARE';
    const CLOUDFRONT = 'CLOUDFRONT';
    const FASTLY = 'FASTLY';
    const KEYCDN = 'KEYCDN';
    const MAXCDN = 'MAXCDN';

    /**
     * @inheritDoc
     */
    protected static function getData()
    {
        return [
            self::AKAMAI => 'Akamai',
            self::CACHEFLY => 'CacheFly',
            self::CLOUDFLARE => 'CloudFlare',
            self::CLOUDFRONT => 'CloudFront',
            self::FASTLY => 'Fastly',
            self::KEYCDN => 'KeyCDN',
            self::MAXCDN => 'MaxCDN',
        ];
    }
}

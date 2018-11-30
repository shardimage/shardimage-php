<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\superbackup\targets;

class AmazonS3Target extends Target
{
    /**
     * @var string[] List of Amazon S3 regions.
     *
     * @link http://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region
     */
    private static $regions = [
        'us-east-1' => 'US East (N. Virginia)',
        'us-east-2' => 'US East (Ohio)',
        'us-west-1' => 'US West (N. California)',
        'us-west-2' => 'US West (Oregon)',
        'ap-south-1' => 'Asia Pacific (Mumbai)',
        'ap-northeast-2' => 'Asia Pacific (Seoul)',
        'ap-southeast-1' => 'Asia Pacific (Singapore)',
        'ap-southeast-2' => 'Asia Pacific (Sydney)',
        'ap-northeast-1' => 'Asia Pacific (Tokyo)',
        'eu-central-1' => 'EU (Frankfurt)',
        'eu-west-1' => 'EU (Ireland)',
        'sa-east-1' => 'South America (São Paulo)',
    ];

    /**
     * @var array List of storage class.
     *
     * @link http://docs.aws.amazon.com/AmazonS3/latest/dev/storage-class-intro.html
     */
    private static $storageClasses = [
        'STANDARD' => 'STANDARD',
        'STANDARD_IA' => 'STANDARD_IA',
        'GLACIER' => 'GLACIER',
        'RRS' => 'RRS',
    ];

    /**
     * @var string Acces key of Amazon aws s3.
     */
    public $accessKey;

    /**
     * @var string Secret key of Amazon aws s3.
     */
    public $secretKey;

    /**
     * @var string Name of the storage class.
     *
     * @link http://docs.aws.amazon.com/AmazonS3/latest/dev/storage-class-intro.html
     */
    public $storageClass;

    /**
     * @var string Name of the Amazon S3 region.
     *
     * @link http://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region
     */
    public $region;

    /**
     * @return array
     */
    public function getStorageClasses()
    {
        return static::$storageClasses;
    }

    /**
     * @return array[]
     */
    public function getRegions()
    {
        return static::$regions;
    }

    public static function getType()
    {
        return 'amazon';
    }
}

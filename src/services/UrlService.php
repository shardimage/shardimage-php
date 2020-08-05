<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\helpers\SecurityHelper;
use shardimage\shardimagephpapi\base\exceptions\InvalidConfigException;
use shardimage\shardimagephpapi\base\exceptions\InvalidValueException;

/**
 * Shardimage URL generator service.
 */
class UrlService extends Service
{
    /**
     * Creates the URL for an internal image.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicID - image ID
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function create($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['publicId' => $params];
        }
        $params = $this->client->fillParams(['cloudId', 'publicId'], $params);

        return $this->build('/i/'.rawurlencode($params['publicId']), $params, $optParams);
    }

    /**
     * Creates the URL for a remote image.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>url - image URL
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createRemote($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['url' => $params];
        }
        unset($optParams['format']);
        $params = $this->client->fillParams(['cloudId', 'url'], $params);

        return $this->build('/r/http/'.rawurlencode($params['url']), $params, $optParams);
    }

    /**
     * Creates the fetch URL for a remote image.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>url - image URL
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createFetch($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['url' => $params];
        }

        $params = $this->client->fillParams(['cloudId', 'url'], $params);

        return $this->build('/f/'.$params['url'], $params, $optParams);
    }

    /**
     * Creates the URL for a Facebook profile picture.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>facebookId - Facebook user ID
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createFacebook($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['facebookId' => $params];
        }
        $params = $this->client->fillParams(['cloudId', 'facebookId'], $params);

        return $this->build('/r/facebook/'.$params['facebookId'], $params, $optParams);
    }

    /**
     * Creates the URL for a Twitter profile picture.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>twitterId - Twitter user ID
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createTwitter($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['twitterId' => $params];
        }
        $params = $this->client->fillParams(['cloudId', 'twitterId'], $params);

        return $this->build('/r/twitter/'.$params['twitterId'], $params, $optParams);
    }

    /**
     * Creates the URL for a YouTube video preview image.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>youtubeId - YouTube video ID
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createYoutube($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['youtubeId' => $params];
        }
        $params = $this->client->fillParams(['cloudId', 'youtubeId'], $params);

        return $this->build('/r/youtube/'.$params['youtubeId'], $params, $optParams);
    }

    /**
     * Creates the URL for a Cloudinary image.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>cloudinaryCloud - Cloudinary cloud ID + folder
     * <li>cloudinaryImage - Cloudinary image ID
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createCloudinary($params, $optParams = [])
    {
        $params = $this->client->fillParams(['cloudId', 'cloudinaryCloud', 'cloudinaryImage'], $params);

        return $this->build('/r/cloudinary/'.rawurlencode($params['cloudinaryCloud'].'/'.$params['cloudinaryImage']), $params, $optParams);
    }

    /**
     * Creates the URL for a Wikimedia commons image.
     *
     * @param array|string $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>wikimediaImage - Wikimedia image URL
     * @param array $optParams Optional API parameters
     *
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    public function createWikimedia($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['wikimediaImage' => $params];
        }
        $params = $this->client->fillParams(['cloudId', 'wikimediaImage'], $params);

        return $this->build('/r/commons/'.rawurlencode($params['wikimediaImage']), $params, $optParams);
    }

    /**
     * Builds the URL.
     *
     * @param string $resource Resource component of URL
     * @param array  $params   Required API parameters
     * <li>cloudId - cloud ID
     *
     * @param array $optParams Optional API parameters
     * <li>option - options defined by shardimage\shardimagephp\factories\Option
     * <li>transformation - transformations defined by shardimage\shardimagephp\factories\Transformation
     * <li>version - version number (to force cache miss)
     * <li>format - output format
     * <li>seo - SEO filename
     * <li>security - "basic" or "token"
     * <li>default_public_id - string, public ID of image which will be served if original image can't
     *
     * @return string
     */
    private function build($resource, $params, $optParams)
    {
        $url = '';
        if (isset($optParams['option'])) {
            $option = (string) $optParams['option'];
            if (!empty($option)) {
                $url .= '/o-'.$option;
            }
        }
        if (isset($optParams['transformation'])) {
            $transformation = (string) $optParams['transformation'];
            if (!empty($transformation)) {
                $url .= '/' . trim($transformation, '/');
            }
        }
        if (isset($optParams['version'])) {
            $url .= '/v/'.$optParams['version'];
        }
        if (isset($optParams['default_public_id'])) {
            $url .= '/d/'.$optParams['default_public_id'];
        }
        $url .= $resource;
        if (isset($optParams['format'])) {
            $url .= '.'.$optParams['format'];
        }
        if (isset($optParams['seo'])) {
            $url .= '/seo/'.$optParams['seo'];
        }
        $security = '';
        if (isset($optParams['security'])) {
            switch ($optParams['security']) {
                case 'basic':
                    if (!$this->client->apiKey || !$this->client->imageSecret) {
                        throw new InvalidConfigException('The apiKey and imageSecret must be specified!');
                    }
                    $security = '/s-b3:'.SecurityHelper::generateImageSecretSignature($this->client->imageHostname, ltrim($url, '/'), $this->client->apiKey, $this->client->imageSecret);
                    break;
                case 'token':
                    if (!$this->client->apiAccessTokenSecret){
                        throw new InvalidConfigException('The apiAccessTokenSecret must be specified!');
                    }
                    $security = '/s-token2:'.$this->client->apiAccessToken.','.SecurityHelper::generateImageTokenSecretSignature($this->client->imageHostname, ltrim($url, '/'), $this->client->apiAccessToken, $this->client->apiAccessTokenSecret);
                    break;
            }
        }
        $result = $this->client->imageHost . '/' . $params['cloudId'] . $security . $url;
        $this->checkUrlSize($result);
        return $result;
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }

    /**
     * Checks the URL size and throws exception if it's over the limit
     * @param string $url
     * @throws InvalidValueException
     */
    private function checkUrlSize($url)
    {
        $urlSizeKilobyte = mb_strlen($url, '8bit') / 1024;
        if ($urlSizeKilobyte > $this->client->getUrlSizeLimit()) {
            throw new InvalidValueException(sprintf('URL size exceeded the limit! (%f > %f)', $urlSizeKilobyte, $this->client->getUrlSizeLimit()));
        }
    }
}

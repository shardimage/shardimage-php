<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephpapi\api\Response;
use shardimage\shardimagephp\helpers\ArrayHelper;
use shardimage\shardimagephp\models\image\Image;

/**
 * Shardimage upload service.
 */
class UploadService extends Service
{
    /**
     * Uploads an image from a local source.
     *
     * @param array|string|resource $params Required API parameters
     *
     * <li>file - source (string - filepath, array - a $_FILES entry,
     * resource - an opened file resource (@see fopen()),
     * an array with a 'file' key consisting of the above 3)
     * <li>cloudId - cloud ID
     * @param array $optParams Optional API parameters
     * 
     * <li>publicId - image ID
     * <li>format - image format
     * <li>transformation - transformations
     * <li>tags - tags
     * <li>plugins - plugins
     *
     * @return Image|Response
     */
    public function upload($params, $optParams = [])
    {
        $resource = null;
        if (is_string($params) || is_resource($params)) {
            $params = ['file' => $params];
        } elseif (is_array($params) && isset($params['tmp_name'])) {
            $params = ['file' => $params['tmp_name']];
        }
        if (isset($params['file']) && is_array($params['file']) && isset($params['file']['tmp_name'])) {
            $params['file'] = $params['file']['tmp_name'];
        }
        if (isset($params['file']) && is_string($params['file'])) {
            $resource = $params['file'] = fopen($params['file'], 'r');
        }
        ArrayHelper::stringify($optParams, [
            'transformation',
        ]);

        return $this->sendRequest(['cloudId', 'file'], [
            'restAction' => 'create',
            'uri' => '/c/<cloudId>',
            'params' => $params,
            'postParams' => array_merge($params, $optParams),
        ], function ($response) use ($resource) {
            if (is_resource($resource)) {
                fclose($resource);
            }

            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    /**
     * Uploads an image from a remote source.
     * 
     * @param array|string $params Required API parameters
     *
     * <li>resource - source (string - URL, an array with a 'remote' key consisting
     * of the above)
     * @param array $optParams Optional API parameters
     * 
     * <li>publicId - image ID
     * <li>format - image format
     * <li>transformation - transformations
     * <li>tags - tags
     * <li>plugins - plugins
     *
     * @return Image|Response
     */
    public function uploadRemote($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['resource' => $params];
        }
        ArrayHelper::stringify($optParams, [
            'transformation',
        ]);

        return $this->sendRequest(['cloudId', 'resource'], [
            'restAction' => 'create',
            'uri' => '/c/<cloudId>/remote',
            'params' => $params,
            'postParams' => array_merge($params, $optParams),
        ], function ($response) {
            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    /**
     * Makes a copy of an image.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicId - image ID
     * <li>newCloudId - new cloud ID, if differs
     * @param array $optParams Optional API parameters
     *
     * @return Image|Response
     */
    public function copy($params, $optParams = [])
    {
        if (isset($params['newCloudId'])) {
            $uri = '/c/<cloudId>/o/<publicId>/copy/c/<newCloudId>';
        } else {
            $uri = '/c/<cloudId>/o/<publicId>/copy';
        }

        return $this->sendRequest(['cloudId', 'publicId'], [
            'restAction' => 'create',
            'uri' => $uri,
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    /**
     * Modifies an image by changing storage format and/or transformations.
     *
     * @param array|string $params Required API parameters
     *
     * <li>publicId - image ID
     * <li>cloudId - cloud ID
     * @param array $optParams Optional API parameters
     *
     * <li>format - image format
     * <li>transformation - transformations
     * <li>tags - tags
     * <li>plugins - plugins
     *
     * @return Image|Response
     */
    public function modify($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['publicId' => $params];
        }
        ArrayHelper::stringify($optParams, [
            'transformation',
        ]);

        return $this->sendRequest(['cloudId', 'file'], [
            'restAction' => 'create',
            'uri' => '/c/<cloudId>/o/<publicId>/modify',
            'params' => $params,
            'postParams' => array_merge($params, $optParams),
        ], function ($response) {
            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    public static function getModule()
    {
        return 'upload';
    }

    public static function getController()
    {
    }
}

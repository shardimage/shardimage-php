<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephpapi\api\Response;
use shardimage\shardimagephp\builders\UploadBuilder;
use shardimage\shardimagephp\helpers\ArrayHelper;
use shardimage\shardimagephp\models\image\Image;
use shardimage\shardimagephp\models\upload\UploadParams;
use shardimage\shardimagephpapi\web\exceptions\NotImplementedHttpException;

/**
 * Shardimage upload service.
 */
class UploadService extends Service
{
    /**
     * Uploads an image from a local source.
     *
     * @param UploadParams|array $params Required API parameters
     *
     * <li>file - source (string - filepath, array - a $_FILES entry,
     * resource - an opened file resource (@see fopen()),
     * an array with a 'file' key consisting of the above 3)
     * <li>publicId - image ID
     * <li>cloudId - cloud ID
     *
     * @param array $optParams Optional API parameters
     *
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
        if ($params instanceof UploadParams) {
            $optParams = array_merge($optParams, $params->getOptionalParams());
            $params = $params->getParams();
        }
        if (!is_array($params)) {
            throw new \InvalidArgumentException('First parameter ($params) must to be an array!');
        }
        if (!isset($params['publicId'])) {
            throw new \InvalidArgumentException('You must set publicId in $params parameter!');
        }
        if (!isset($params['file']) && isset($params['tmp_name'])) {
            $params['file'] = $params['tmp_name'];
        }
        if (isset($params['file']) && is_array($params['file']) && isset($params['file']['tmp_name'])) {
            $params['file'] = $params['file']['tmp_name'];
        }
        if (isset($params['file']) && is_string($params['file'])) {
            $resource = $params['file'] = fopen($params['file'], 'r');
        }
        $optParams['publicId'] = $params['publicId'];
        unset($params['publicId']);
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
     * @param UploadParams|array $params Required API parameters
     *
     * <li>resource - source (string - URL, an array with a 'remote' key consisting
     * of the above)
     * <li>publicId - image ID
     * @param array $optParams Optional API parameters
     *
     * <li>format - image format
     * <li>transformation - transformations
     * <li>tags - tags
     * <li>plugins - plugins
     *
     * @return Image|Response
     */
    public function uploadRemote($params, $optParams = [])
    {
        if ($params instanceof UploadParams) {
            $optParams = array_merge($optParams, $params->getOptionalParams());
            $params = $params->getParams();
        }
        if (!is_array($params)) {
            throw new \InvalidArgumentException('First parameter ($params) must to be an array!');
        }
        if (!isset($params['publicId'])) {
            throw new \InvalidArgumentException('You must set publicId in $params parameter!');
        }
        $optParams['publicId'] = $params['publicId'];
        unset($params['publicId']);
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
     * @throws NotImplementedHttpException
     */
    public function copy($params, $optParams = [])
    {
        throw new NotImplementedHttpException('This method is under development in Shardimage API.');
    }

    /**
     * Modifies an image by changing storage format and/or transformations.
     *
     * @param UploadParams|array|string $params Required API parameters
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
        if ($params instanceof UploadParams) {
            $optParams = array_merge($optParams, $params->getOptionalParams());
            $params = $params->getParams();
        }
        if (is_string($params)) {
            $params = ['publicId' => $params];
        }
        ArrayHelper::stringify($optParams, [
            'transformation',
        ]);

        return $this->sendRequest(['cloudId', 'publicId'], [
            'restAction' => 'update',
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

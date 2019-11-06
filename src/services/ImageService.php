<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\helpers\ArrayHelper;
use shardimage\shardimagephp\models\image\Image;
use shardimage\shardimagephp\models\image\Index;
use shardimage\shardimagephp\models\image\IndexParams;
use shardimage\shardimagephp\models\image\ViewParams;
use shardimage\shardimagephp\models\job\Job;
use shardimage\shardimagephpapi\api\Response;

/**
 * Shardimage image service.
 */
class ImageService extends Service
{
    /**
     * Fetches all images.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * @param IndexParams|array $optParams Optional API parameters
     *
     * <li>projection - an array of projection flags: noExif, noObject, noDimensions
     * <li>order - the order of results: latest, publicId
     * <li>maxResults - number of results
     * <li>pageToken - token for next result page
     * <li>nextPageTokenType - type of paging token: shortTime, longTime
     * <li>prefix - prefix of publicId for filtering
     * <li>byTag - image tag for filtering
     *
     * @return Index
     */
    public function index($params = [], $optParams = [])
    {
        if ($optParams instanceof IndexParams) {
            $optParams = $optParams->toArray(true);
        }
        if (is_string($params)) {
            $params = ['cloudId' => $params];
        }

        return $this->sendRequest(['cloudId'], [
            'restAction' => 'index',
            'uri' => '/c/<cloudId>',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) use ($params) {
            $images = [];
            foreach ($response->data['items'] as $image) {
                if (!isset($image['cloudId'])) {
                    $image['cloudId'] = $this->client->getParam($params, 'cloudId');
                }
                $images[] = new Image($image);
            }

            return new Index([
                'models' => $images,
                'nextPageToken' => $response->data['nextPageToken'],
            ]);
        });
    }

    /**
     * Fetches an image.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicId - image ID
     * @param ImageViewParams|array $optParams Optional API parameters
     *
     * <li>projection - an array of projection flags: noExif, noObject, noDimensions
     *
     * @return Image|Response
     */
    public function view($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['publicId' => $params];
        }
        if ($optParams instanceof ViewParams) {
            $optParams = $optParams->toArray(true);
        }

        return $this->sendRequest(['cloudId', 'publicId'], [
            'restAction' => 'view',
            'uri' => '/c/<cloudId>/o/<publicId>',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) use ($params) {
            if ($response->data && !isset($response->data['cloudId'])) {
                $response->data['cloudId'] = $this->client->getParam($params, 'cloudId');
            }

            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    /**
     * Renames the ID of an image.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicId - image ID
     * <li>newPublicId - new image ID
     * @param array $optParams Optional API parameters
     *
     * @return Image|Response
     */
    public function rename($params, $optParams = [])
    {
        return $this->sendRequest(['cloudId', 'publicId', 'newPublicId'], [
            'restAction' => 'update',
            'uri' => '/c/<cloudId>/o/<publicId>/rename/o/<newPublicId>',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) use ($params) {
            if ($response->data && !isset($response->data['cloudId'])) {
                $response->data['cloudId'] = $this->client->getParam($params, 'cloudId');
            }

            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    /**
     * Updates an image tags or plugins.
     *
     * @param Image|array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicId - image ID
     * @param array $optParams Optional API parameters
     *
     * <li>tags - an array with the new tags. It will overwrite the image's current tags.
     * <li>plugin - string plugin to execute.
     *
     * @return type
     */
    public function update($params, $optParams = [])
    {
        if ($params instanceof Image) {
            $imageObject = $params;
            $params = [];
            $params['cloudId'] = $imageObject->cloudId;
            $params['publicId'] = $imageObject->publicId;
        }
        return $this->sendRequest(['cloudId', 'publicId'], [
            'restAction' => 'update',
            'uri' => '/c/<cloudId>/o/<publicId>',
            'params' => $params,
            'postParams' => $optParams,
        ], function ($response) use ($params) {
            if ($response->data && !isset($response->data['cloudId'])) {
                $response->data['cloudId'] = $this->client->getParam($params, 'cloudId');
            }

            return isset($response->data) ? new Image($response->data) : $response;
        });
    }

    /**
     * Deletes an image.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicId - image ID
     * @param array $optParams Optional API parameters
     *
     * @return bool
     */
    public function delete($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['publicId' => $params];
        }

        return $this->sendRequest(['cloudId', 'publicId'], [
            'restAction' => 'delete',
            'uri' => '/c/<cloudId>/o/<publicId>',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return $response->success;
        });
    }

    /**
     * Deletes images by tag.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>tag - image tag
     * @param array $optParams Optional API parameters
     *
     * @return Job|Response
     */
    public function deleteByTag($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['tag' => $params];
        }

        return $this->sendRequest(['cloudId', 'tag'], [
            'restAction' => 'delete',
            'uri' => '/c/<cloudId>/t/<tag>',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return isset($response->data) ? new Job($response->data) : $response;
        });
    }

    /**
     * Returns whether an image exists.
     *
     * @param array $params Required API parameters
     *
     * <li>cloudId - cloud ID
     * <li>publicId - image ID
     * @param array $optParams Optional API parameters
     *
     * @return bool
     */
    public function exists($params, $optParams = [])
    {
        if (is_string($params)) {
            $params = ['publicId' => $params];
        }

        return $this->sendRequest(['cloudId', 'publicId'], [
            'restAction' => 'exists',
            'uri' => '/c/<cloudId>/o/<publicId>',
            'params' => $params,
            'getParams' => $optParams,
        ], function ($response) {
            return $response->success;
        });
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
        return 'image';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
    }
}

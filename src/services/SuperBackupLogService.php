<?php

/**
 * @see https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\services;

use shardimage\shardimagephp\models\superbackuplog\Index;
use shardimage\shardimagephp\models\superbackuplog\IndexParams;
use shardimage\shardimagephp\models\superbackuplog\SuperBackupLog;

/**
 * Shardimage superbackup log service.
 */
class SuperBackupLogService extends Service
{

    /**
     * Fetches all existing backups.
     *
     * @param array $params    Required API parameters
     * @param array|IndexParams $optParams Optional API parameters
     *
     * @return Index
     */
    public function index($params = [], $optParams = [])
    {
        if ($optParams instanceof IndexParams) {
            $optParams = $optParams->toArray(true);
        }
        if (!isset($params['cloudId'])) {
            $params['cloudId'] = $this->client->cloudId;
        }
        return $this->sendRequest([], [
            'restAction' => 'index',
            'uri' => '/c/<cloudId>/log',
            'params' => $params,
            'getParams' => $optParams,
                ], function ($response) {
            $backupLogs = [];
            if (isset($response->data['items'])) {
                foreach ($response->data['items'] as $superbackuplog) {
                    $backupLogs[] = new SuperBackupLog($superbackuplog);
                }
            }
            return new Index([
                'models' => $backupLogs,
                'nextPageToken' => $response->data['nextPageToken'],
                'lastScannedTime' => $response->data['lastScannedTime'],
            ]);
        });
    }

    /**
     * @inheritDoc
     */
    public static function getModule()
    {
        return 'super-backup';
    }

    /**
     * @inheritDoc
     */
    public static function getController()
    {
        
    }

}

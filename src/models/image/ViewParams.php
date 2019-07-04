<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\image;

use shardimage\shardimagephpapi\base\BaseObject;

class ViewParams extends BaseObject
{

    const PROJECTION_NO_OBJECT = 'noObject';
    const PROJECTION_NO_EXIF = 'noExif';
    const PROJECTION_NO_DIMENSIONS = 'noDimensions';
    const PROJECTION_METADATA = 'metadata';
    const PROJECTION_METADATA_HR = 'metadataHR';
    const PROJECTION_METADATA_XML = 'metadataXML';
    const PROJECTION_NO_TAGS = 'noTags';
    const PROJECTION_DETECTION = 'detection';
    const PROJECTION_SUPERBACKUP_INFO = 'superBackupInfo';

    /**
     * @var array
     */
    public $projection = [];

    /**
     * @inheritDoc
     */
    public function toArray($excludeEmpty = false)
    {
        $result = parent::toArray($excludeEmpty);
        if (isset($result['projection']) && !empty($result['projection'])) {
            $result['projection'] = implode(',', $result['projection']);
        }

        return $result;
    }

}

<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "exif".
 *
 * @property int $id
 * @property string $data
 * @property int $image_id
 *
 * @property Images $image
 */
class Images extends \frontend\models\Images 
{

    public function deleteFiles()
    {
        //delete main image file
        unlink(\Yii::getAlias('@webroot') . '/images/' . $this->path);
        //delete thumbnails files
        foreach ($this->thumbnails as $thumb) {
            unlink(\Yii::getAlias('@webroot') . '/' . $thumb->path);
        }
    }
    
    /**
     * Get current host on different servers and domains
     */
    public function getHost(): string
    {
        $host = explode('.', Url::base('https'));
        $firstLevelDomen = array_pop($host);
        $rawSecondlevelDomen = array_pop($host);
        $rawSecondlevelDomen = explode('-', $rawSecondlevelDomen);
        $secondlevelDomen = array_pop($rawSecondlevelDomen);
        $host = 'http://' . $secondlevelDomen . '.' . $firstLevelDomen . '/';
        return $host;
    }
    
}

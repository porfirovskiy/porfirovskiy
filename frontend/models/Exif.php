<?php

namespace frontend\models;

use Yii;
use yii\imagine\Image;
use Imagine\Image\Metadata\ExifMetadataReader;

/**
 * This is the model class for table "exif".
 *
 * @property int $id
 * @property string $data
 * @property int $image_id
 *
 * @property Images $image
 */
class Exif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'image_id'], 'required'],
            [['data'], 'string'],
            [['image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'image_id' => 'Image ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }
    
    /**
     * 
     * @param string $path
     * @param int $imageId
     * @return void
     */
    public function saveData(string $path, int $imageId): void 
    {
        $model = new Exif();
        $model->data = $this->getExifData($path);
        $model->image_id = $imageId;
        $model->save();
    }
    
    /**
     * 
     * @param string $path
     * @return string
     */
    private function getExifData(string $path): string 
    {
        $imagine = Image::getImagine();
        $reader = $imagine->setMetadataReader(new ExifMetadataReader())->open($path);
        $metaData = $reader->metadata()->toArray();
        return json_encode($metaData);
    }
    
}

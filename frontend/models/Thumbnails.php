<?php

namespace frontend\models;

use Yii;
use yii\imagine\Image;
use frontend\models\UploadForm;

/**
 * This is the model class for table "thumbnails".
 *
 * @property int $id
 * @property string $path
 * @property string $type
 * @property int $size
 * @property int $image_id
 *
 * @property Images $image
 */
class Thumbnails extends \yii\db\ActiveRecord
{
    const BIG_TYPE = 'big';
    const MEDIUM_TYPE = 'medium';
    const SMALL_TYPE = 'small';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thumbnails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'size', 'image_id'], 'required'],
            [['type'], 'string'],
            [['size', 'image_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
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
            'path' => 'Path',
            'type' => 'Type',
            'size' => 'Size',
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
     * @param UploadForm $model
     * @return void
     */
    public function makeThumbnails(UploadForm $model, int $imageId): void 
    {
        //generate a thumbnail image 150x150
        $this->generateThumbnail($model, 150, 150, self::SMALL_TYPE, $imageId);
        //generate a thumbnail image 800x600
        $this->generateThumbnail($model, 800, 600, self::BIG_TYPE, $imageId);

        //var_dump($path);die();
    }
        
    /**
     * 
     * @param UploadForm $model
     * @param string $width
     * @param string $hight
     * @param string $type
     * @return void
     */
    private function generateThumbnail(UploadForm $model, string $width, string $hight, string $type, int $imageId): void 
    {
        $dir = $model->getImageDir($model->thumbDir);
        $path = $dir . $model->imageName . '_' . $type . '.' . $model->imageFile->extension;
        Image::thumbnail($model->imagePath, $width, $hight)
            ->save($path, ['quality' => 100]);
        //save info to db    
        $thumbnail = new Thumbnails();
        $thumbnail->path = $path;
        $thumbnail->type = $type;
        $thumbnail->size = filesize($path);
        $thumbnail->image_id = $imageId;
        $thumbnail->save();
    }
}

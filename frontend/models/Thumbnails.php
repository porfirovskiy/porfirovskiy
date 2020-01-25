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
    const SMALL_WIDTH = 200;
    const MEDIUM_WIDTH = 300;
    const BIG_WIDTH = 1000;
    const THUMBNAIL_QUALITY = 100;
    
    
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
            [['size', 'image_id', 'width', 'hight'], 'integer'],
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
            'width' => 'Width',
            'hight' => 'Hight',
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
     * @param int $imageId
     * @return void
     */
    public function makeThumbnails(UploadForm $model, int $imageId): void 
    {
        $imageParams = $model->getImageParams($model->imagePath);
        
        //generate a thumbnail image 150x150
        $newParams = $this->getImageProportialParams($imageParams['width'], $imageParams['hight'], self::SMALL_WIDTH);
        $this->generateThumbnail($model, $newParams['width'], $newParams['hight'], self::SMALL_TYPE, $imageId);
        
        //generate a thumbnail image 1000x600
        $newBigParams = $this->getImageProportialParams($imageParams['width'], $imageParams['hight'], self::BIG_WIDTH);
        $this->generateThumbnail($model, $newBigParams['width'], $newBigParams['hight'], self::BIG_TYPE, $imageId);
    }
        
    /**
     * 
     * @param UploadForm $model
     * @param string $width
     * @param string $hight
     * @param string $type
     * @param int $imageId
     * @return void
     */
    private function generateThumbnail(UploadForm $model, string $width, string $hight, string $type, int $imageId): void 
    {
        $dir = $model->getImageDir($model->thumbDir);
        $path = $dir . $model->imageName . '_' . $type . '.' . $model->imageExtension;
        Image::thumbnail($model->imagePath, $width, $hight, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)
            ->save($path, ['quality' => self::THUMBNAIL_QUALITY]);
        
        $this->saveThumbnail($path, $width, $hight, $type, $imageId);
    }
    
    /**
     * Save thumbnail into to db 
     * @param string $path
     * @param string $width
     * @param string $hight
     * @param string $type
     * @param int $imageId
     * @return void
     */
    private function saveThumbnail(string $path, string $width, string $hight, string $type, int $imageId): void
    {
        $thumbnail = new Thumbnails();
        $thumbnail->path = $path;
        $thumbnail->type = $type;
        $thumbnail->width = $width;
        $thumbnail->hight = $hight;
        $thumbnail->size = filesize($path);
        $thumbnail->image_id = $imageId;
        $thumbnail->save();
    }
    
    /**
     * 
     * @param int $originWidth
     * @param int $originHight
     * @param int $newWidth
     * @return int
     */
    private function getProportialHight(int $originWidth, int $originHight, int $newWidth): int
    {
        $newHight = ($newWidth * $originHight) / $originWidth;
        return intval(round($newHight));
    }
    
    /**
     * 
     * @param int $originWidth
     * @param int $originHight
     * @param int $newWidth
     * @return array
     */
    private function getImageProportialParams(int $originWidth, int $originHight, int $newWidth): array {
        //left old params
        if ($newWidth > $originWidth) {
            return ['width' => $originWidth, 'hight' => $originHight];
        } else {
            //get new params
            $newHight = $this->getProportialHight($originWidth, $originHight, $newWidth);
            return ['width' => $newWidth, 'hight' => $newHight];
        }
    }
    
}

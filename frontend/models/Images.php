<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\Tags;
use frontend\models\Thumbnails;
use frontend\models\Descriptions;
use frontend\models\MultipleUploadForm;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $origin_name
 * @property string $translit_name
 * @property string $path
 * @property int $width
 * @property int $hight
 * @property int $size
 * @property int $user_id
 * @property string $created
 *
 * @property Comments[] $comments
 * @property Descriptions[] $descriptions
 * @property User $user
 * @property ImagesTags[] $imagesTags
 * @property Thumbnails[] $thumbnails
 */
class Images extends \yii\db\ActiveRecord
{
    const PUBLIC_STATUS = 'public';
    const PRIVATE_STATUS = 'private';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'origin_name', 'translit_name', 'path', 'width', 'hight', 'size', 'user_id', 'created', 'hash'], 'required'],
            [['width', 'hight', 'size', 'user_id'], 'integer'],
            [['created', 'source'], 'safe'],
            [['name', 'origin_name', 'translit_name', 'path', 'source'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'translit_name' => 'Translit Name',
            'origin_name' => 'Origin Name',
            'path' => 'Path',
            'width' => 'Width',
            'hight' => 'Hight',
            'size' => 'Size',
            'user_id' => 'User ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescriptions()
    {
        return $this->hasMany(Descriptions::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesTags()
    {
        return $this->hasMany(ImagesTags::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getTags()
    {
        return $this->hasMany(Tags::className(), ['image_id' => 'id']);
    }*.
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThumbnails()
    {
        return $this->hasMany(Thumbnails::className(), ['image_id' => 'id']);
    }
    
    public function saveDescription(string $text, int $imageId): void {
        if (isset($text) && !empty($text)) {
            $descModel = new Descriptions();
            $descModel->text = $text;
            $descModel->image_id = $imageId;
            $descModel->save();
        }
    }
    
    /**
     * Get current image status values for controll
     * access to images from guests and admin
     * @return array
     */
    public static function getCurrentStatusValues(): array 
    {
        if(Yii::$app->user->isGuest) {
            return [self::PUBLIC_STATUS];
        } else {
            return [self::PUBLIC_STATUS, self::PRIVATE_STATUS];
        }
    }
    
    /**
     * Save current image to db
     * @param \frontend\models\UploadForm $model
     * @param string $formType
     * @return void
     */
    public function saveCurrentImage(UploadForm $model, string $formType): void
    {
        $this->name = $model->name;
        $this->source = $model->source;
        $this->translit_name = \yii\helpers\Inflector::slug($this->name, '-');
        $this->origin_name = ($formType == UploadForm::FORM_TYPE_FILE) ? $model->imageFile->baseName : $model->imageUrl;
        $this->path = str_replace($model->dir, '', $model->imagePath);
        $this->hash = $model->hash;
        $imageParams = $model->getImageParams($model->imagePath);
        $this->width = $imageParams['width'];
        $this->hight = $imageParams['hight'];
        $this->size = filesize($model->imagePath);
        $this->user_id = \Yii::$app->user->identity->id;
        $this->status = $model->status;
        $this->created = date('Y-m-d H:i:s');
        if ($this->save()) {
            $this->saveImageRelativesEntities($model);
            Yii::$app->session->setFlash('success', \Yii::t('common', 'Image saved!'));
        } else {
            Yii::$app->session->setFlash('error', \Yii::t('common', 'Model not saved!'));
        }
    }
    
    /**
     * Save image tags, desc., exif, thumbnails 
     * @param \frontend\models\UploadForm $model
     * @return void
     */
    protected function saveImageRelativesEntities(UploadForm $model): void
    {
        $imageId = $this->getPrimaryKey();
        //save tags to db
        $tagsModel = new Tags();
        $tagsModel->saveImageTags($model->tags, $imageId);
        //save image exif to db
        $exifModel = new Exif();
        $exifModel->saveData($model->imagePath, $imageId);
        //save description
        $this->saveDescription($model->description, $imageId);
        //make thumbnails
        $thumbnailsModel = new Thumbnails();
        $thumbnailsModel->makeThumbnails($model, $imageId);
    }
    
}

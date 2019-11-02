<?php

namespace frontend\models;

use Yii;
use common\models\User;

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
            [['name', 'origin_name', 'translit_name', 'path', 'width', 'hight', 'size', 'user_id', 'created'], 'required'],
            [['width', 'hight', 'size', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['name', 'origin_name', 'translit_name', 'path'], 'string', 'max' => 255],
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
}

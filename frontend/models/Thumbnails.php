<?php

namespace frontend\models;

use Yii;

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
}

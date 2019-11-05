<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property string $title
 *
 * @property ImagesTags[] $imagesTags
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesTags()
    {
        return $this->hasMany(ImagesTags::className(), ['tag_id' => 'id']);
    }
    
    /**
     * 
     * @param array $tags
     * @param string $imageId
     * @return void
     */
    public function saveImagesTags(array $tags, string $imageId): void 
    {
        $splitedTags = $this->splitTags($tags, $imageId);
        if (isset($splitedTags['new']) && !empty($splitedTags['new'])) {
            $this->saveTags($splitedTags['new'], $imageId);
        }
    }
    
    public function saveTags(array $tags, string $imageId): void 
    {
        
    }
    
    public function splitTags(array $tags, string $imageId): void 
    {
        
    }
}

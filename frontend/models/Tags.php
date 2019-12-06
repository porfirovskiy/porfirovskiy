<?php

namespace frontend\models;

use Yii;

use yii\helpers\ArrayHelper;
use frontend\models\ImagesTags;

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
    public function saveImageTags(array $tags, int $imageId): void
    {
        $tagsIds = [];
        $existTags = $this->getByTitles($tags);
        $diff = $this->getDiffTags($tags, $existTags);
        if (!empty($diff)) {
            foreach ($diff as $tag) {
                $tagModel = new Tags();
                $tagModel->title = $tag;
                $tagModel->translit_title = \yii\helpers\Inflector::slug($tag, '-');
                $tagModel->save();
                $tagsIds[] = $tagModel->getPrimaryKey();
            }
        }
        $tagsIds = $this->mergeTagsIds($tagsIds, $existTags);
        $this->saveImageTagsRecords($tagsIds, $imageId);
    }
    
    /**
     * 
     * @param array $tagsIds
     * @param array $imageId
     * @return void
     */
    public function saveImageTagsRecords(array $tagsIds, int $imageId): void {
        foreach ($tagsIds as $tagId) {
            $model = new ImagesTags();
            $model->image_id = $imageId;
            $model->tag_id = $tagId;
            $model->save();
        }
    }

    /**
     * 
     * @param array $ids
     * @param array $existTags
     * @return array
     */
    public function mergeTagsIds(array $ids, array $existTags): array
    {
        $existIds = ArrayHelper::getColumn($existTags, function ($element) {
            return (int)$element['id'];
        });
        return array_merge($ids, $existIds);
    }

    /**
     * 
     * @param array $tags
     * @param array $existTags
     * @return array
     */
    public function getDiffTags(array $tags, array $existTags): array
    {
        return array_diff($tags, ArrayHelper::getColumn($existTags, 'title'));
    }

    /**
     * 
     * @param array $titles
     * @return array
     */
    public function getByTitles(array $titles): array {
        return self::find()
                ->select('title, id')
                ->where(['in', 'title', $titles])
                ->asArray()
                ->all();
    }
}

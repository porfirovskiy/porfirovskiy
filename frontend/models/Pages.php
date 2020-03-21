<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $created
 */
class Pages extends \yii\db\ActiveRecord
{
    const PUBLIC_STATUS = 'public';
    const PRIVATE_STATUS = 'private';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'created'], 'required'],
            [['content'], 'string'],
            [['created', 'status'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Name',
            'content' => 'Content',
            'status' => 'Status',
            'created' => 'Created'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageComments()
    {
        return $this->hasMany(PageComments::className(), ['page_id' => 'id']);
    }

    /**
     * Get current statuses for page
     * @return array
     */
    public static function getCurrentStatuses(): array 
    {
        if(Yii::$app->user->isGuest) {
            return [self::PUBLIC_STATUS];
        } else {
            return [self::PUBLIC_STATUS, self::PRIVATE_STATUS];
        }
    }
}

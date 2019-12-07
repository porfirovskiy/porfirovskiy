<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $comment
 * @property int $image_id
 * @property int $user_id
 * @property string $created
 *
 * @property Images $image
 * @property User $user
 */
class Comments extends \yii\db\ActiveRecord
{
    public $verifyCode;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'image_id', 'created'], 'required'],
            [['comment', 'name'], 'string'],
            [['image_id', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            // verifyCode needs to be entered correctly
            [['verifyCode'], 'required'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'image_id' => 'Image ID',
            'user_id' => 'User ID',
            'created' => 'Created',
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

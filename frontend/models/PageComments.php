<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "page_comments".
 *
 * @property int $id
 * @property string $name
 * @property string $comment
 * @property int $page_id
 * @property string $created
 *
 * @property Pages $page
 */
class PageComments extends \yii\db\ActiveRecord
{
    public $reCaptcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'page_id', 'created'], 'required'],
            [['comment'], 'string'],
            [['page_id'], 'integer'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '6LdI75AaAAAAANhTm_4ejIKDrV5ylkryXBi-aip2',
                'uncheckedMessage' => \Yii::t('common', 'Confirm that you not robot.')
            ]
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
            'comment' => 'Comment',
            'page_id' => 'Page ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }
}

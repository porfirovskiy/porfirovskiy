<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Pages;

/**
 * ContactForm is the model behind the contact form.
 */
class PageForm extends Model
{
    public $title;
    public $content;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('common', 'Title'),
            'content' => Yii::t('common', 'Content')
        ];
    }

    /**
     * 
     * @return bool
     */
    public function savePage(): bool
    {
        $model = new Pages();
        $model->title = $this->title;
        $model->translit_title = \yii\helpers\Inflector::slug($this->title, '-');
        $model->content = $this->content;
        $model->created = date('Y-m-d H:i:s');
        
        return $model->save();
    }
}

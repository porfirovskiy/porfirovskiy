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
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('common', 'Title'),
            'content' => Yii::t('common', 'Content'),
            'status' => Yii::t('common', 'Status')
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
        $model->status = $this->status;
        $model->created = date('Y-m-d H:i:s');
        
        return $model->save();
    }
    
    public function update(int $id): bool
    {
        $page = Pages::findOne(['id' => $id]);
        $page->title = $this->title;
        $page->content = $this->content;
        $page->status = $this->status;
        $page->translit_title = \yii\helpers\Inflector::slug($this->title, '-');
        return $page->update();
    }
}

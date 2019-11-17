<?php

namespace frontend\controllers;

use frontend\models\Tags;
use frontend\models\Images;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView(string $title)
    {
        $images = Images::find()
                ->select('images.*')
                ->leftJoin('images_tags', 'images_tags.image_id = images.id')
                ->leftJoin('tags', 'tags.id = images_tags.tag_id')
                ->where(['tags.title' => $title])
                ->asArray()
                ->all();
        echo '<pre>';var_dump($images);die();
        //$images = ArrayHelper::getColumn($images, 'title');
        return $this->render('view');
    }
    
    public function actionAutocomplete(string $q)
    {   
        if(\Yii::$app->request->isAjax) {
            $tags = Tags::find()
                ->select('title AS id, title AS text')
                ->where(['like', 'title', $q])
                ->limit(10)
                ->asArray()
                ->all();
            return json_encode($tags);
        }
    }

}

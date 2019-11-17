<?php

namespace frontend\controllers;

use frontend\models\Tags;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView(string $title)
    {
        /*$images = ImagesTags::find()
                ->select('tags.title')
                ->leftJoin('images', 'images.id = images_tags.image_id')
                ->where(['images_tags.image_id' => $id])
                ->asArray()
                ->all();
        $images = ArrayHelper::getColumn($images, 'title');*/
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

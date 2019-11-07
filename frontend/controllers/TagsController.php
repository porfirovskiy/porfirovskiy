<?php

namespace frontend\controllers;

use frontend\models\Tags;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionAutocomplete(string $q)
    {   
        if(\Yii::$app->request->isAjax) {
            $tags = Tags::find()
                ->select('title AS id, title AS text')
                ->where(['like', 'title', $q])
                ->asArray()
                ->all();
            return json_encode($tags);
        }
    }

}

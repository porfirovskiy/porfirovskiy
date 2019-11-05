<?php

namespace frontend\controllers;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionAutocomplete(string $q)
    {   
        if(\Yii::$app->request->isAjax) {
            return json_encode([['id' => 1, 'text' => 'test']]);
        }
    }

}

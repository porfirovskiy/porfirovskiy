<?php

namespace frontend\controllers;

use frontend\models\PageForm;
use Yii;

class PagesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        /*$query = Tags::getTagsQuery();
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $tags = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->render('index', [
            'tags' => $tags,
            'pages' => $pages
        ]);*/
    }
    
    public function actionCreate() {
        $model = new PageForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->savePage()) {
                Yii::$app->session->setFlash('success', 'Page created.');
            } else {
                Yii::$app->session->setFlash('error', 'Error, page not created!');
            }
            
            return $this->refresh();
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }


}

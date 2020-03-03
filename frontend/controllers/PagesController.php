<?php

namespace frontend\controllers;

use frontend\models\PageForm;
use frontend\models\Pages;
use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;

class PagesController extends \yii\web\Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $query = Pages::find();
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $pagesList = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->render('index', [
            'pagesList' => $pagesList,
            'pages' => $pages
        ]);
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

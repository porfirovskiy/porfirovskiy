<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Pages;
use frontend\models\PageForm;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class PagesController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update, delete, tags'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update, delete, tags'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pages::find(),
            'pagination' => [
                'pageSize' => 40
            ],
        ]);
        
        return $this->render('pages', [
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionUpdate(int $id)
    {
        $page = Pages::findOne($id);  
        $model = new PageForm();
        
        //set standart fields
        $model->title = $page->title;
        $model->content = $page->content;
        $model->status = $page->status;
        
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->update($id)) {
                Yii::$app->session->setFlash('success', \Yii::t('common', 'Page updated!'));
            } else {
                Yii::$app->session->setFlash('error', \Yii::t('common', 'Error: page not updated!'));
            }
        }
        return $this->render('update', [
            'model' => $model,
            'page' => $page
        ]);
    }
    
    public function actionDelete(int $id) 
    {
        $page = Pages::findOne($id);
        $page->delete();
        Yii::$app->session->setFlash('success', \Yii::t('common', 'Page with ID: ' . $id . ' deleted!'));
        
        return $this->redirect(['pages/index']);
    }
    
}

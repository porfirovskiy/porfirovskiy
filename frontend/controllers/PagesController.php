<?php

namespace frontend\controllers;

use frontend\models\PageForm;
use frontend\models\Pages;
use frontend\models\PageComments;
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
        $query = Pages::find()->andWhere(['in', 'status', Pages::getCurrentStatuses()]);
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
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

    /**
     * 
     * @param int $id
     * @return type
     */
    public function actionView(int $id) 
    {
        $page = Pages::find()->where(['id' => $id])->andWhere(['in', 'status', Pages::getCurrentStatuses()])->one();
        
        if (is_null($page)) {
            throw new \yii\web\NotFoundHttpException(\Yii::t('common', 'Page not found'));
        }

        $commentModel = new PageComments();

        return $this->render('view', [
            'page' => $page,
            'commentModel' => $commentModel
        ]);
    }

    public function actionAddComment()
    {
        $model = new PageComments();
        $model->created = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post())) {
            $model->comment =  htmlspecialchars($model->comment);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', \Yii::t('common', 'Comment saved!'));
            } else {
                \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($model->getErrors()));
            }
        } else {
            \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($model->getErrors()));
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

}

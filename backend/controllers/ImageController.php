<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use backend\models\Images;
use frontend\models\Tags;
use frontend\models\Thumbnails;
use frontend\models\ImagesTags;
use frontend\models\Exif;
use frontend\models\Descriptions;
use frontend\models\ImagesSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ImageController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update, delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update, delete'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }
    
    public function actionUpdate(int $id)
    {
        $model = Images::findOne($id);  
        //echo '<pre>';var_dump($model);die();
        return $this->render('update', ['model' => $model]);
    }
    
    public function actionDelete(int $id) 
    {
        $image = Images::findOne($id);
        $image->deleteFiles();
        $image->delete();
        Yii::$app->session->setFlash('success', \Yii::t('common', 'Image with ID: ' . $id . ' deleted!'));
        
        return $this->goHome();
    }
    
}

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
        $model = new UploadForm();
        $request = Yii::$app->request;
        $model->load($request->post());
        if ($request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {                               
                //save image data to db
                $image = new Images();
                $image->name = $model->name;
                $image->source = $model->source;
                $image->translit_name = \yii\helpers\Inflector::slug($image->name, '-');
                $image->origin_name = $model->imageFile->baseName;
                $image->path = str_replace($model->dir, '', $model->imagePath);
                $image->hash = $model->hash;
                $imageParams = $model->getImageParams($model->imagePath);
                $image->width = $imageParams['width'];
                $image->hight = $imageParams['hight'];
                $image->size = $model->imageFile->size;
                $image->user_id = \Yii::$app->user->identity->id;
                $image->created = date('Y-m-d H:i:s');
                if ($image->save()) {
                    $imageId = $image->getPrimaryKey();
                    //save tags to db
                    $tagsModel = new Tags();
                    $tagsModel->saveImageTags($model->tags, $imageId);
                    //save image exif to db
                    $exifModel = new Exif();
                    $exifModel->saveData($model->imagePath, $imageId);
                    //save description
                    $image->saveDescription($model->description, $imageId);
                    //make thumbnails
                    $thumbnailsModel = new Thumbnails();
                    $thumbnailsModel->makeThumbnails($model, $imageId);
                    Yii::$app->session->setFlash('success', \Yii::t('common', 'Image saved!'));
                } else {
                    Yii::$app->session->setFlash('error', \Yii::t('common', 'Model not saved!'));
                }
            }
        }

        return $this->render('upload', ['model' => $model]);
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
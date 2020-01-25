<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use frontend\models\Images;
use frontend\models\Tags;
use frontend\models\Thumbnails;
use frontend\models\ImagesTags;
use frontend\models\Exif;
use frontend\models\Descriptions;
use frontend\models\ImagesSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use frontend\models\Comments;
use frontend\models\UploadUrlForm;
use frontend\models\MultipleUploadForm;

class ImageController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['upload'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'foreColor' => 0xFE980F, // цвет символов
                'minLength' => 4, // минимальное количество символов
                'maxLength' => 5, // максимальное
                'offset' => -1, // расстояние между символами (можно отрицательное)
            ],
        ];
    }
    
    public function actionUpload()
    {
        $model = new UploadForm();
        $request = Yii::$app->request;
        $model->load($request->post());
        if ($request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {                               
                //save image data to db
                $image = new Images();
                $image->saveCurrentImage($model, UploadUrlForm::FORM_TYPE_FILE);
            }
        }
            
        $model->status = 'public';
        
        return $this->render('upload', [
            'model' => $model,
            'formType' => UploadForm::FORM_TYPE_FILE
        ]);
    }
    
    public function actionUploadByUrl()
    {
        $model = new UploadUrlForm();
        $request = Yii::$app->request;
        $model->load($request->post());
        if ($request->isPost) {
            if ($model->upload()) {                               
                //save image data to db
                $image = new Images();
                $image->saveCurrentImage($model, UploadUrlForm::FORM_TYPE_URL);
            }
        }
        
        $model->status = 'public';
        
        return $this->render('upload', [
            'model' => $model,
            'formType' => UploadUrlForm::FORM_TYPE_URL
        ]);
    }
    
    public function actionMultipleUpload()
    {
        $model = new MultipleUploadForm();
        $request = Yii::$app->request;
        $model->load($request->post());
        if ($request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {                               
                //save images data to db
                $model->saveCurrentMultipleImages();
            }
        }
            
        $model->status = 'public';
        
        return $this->render('multiple_upload', [
            'model' => $model
        ]);
    }
    
    public function actionView(int $id) 
    {
        $image = Images::find()
                    ->where(['id' => $id])
                    ->andWhere(['in', 'status', Images::getCurrentStatusValues()])
                ->one();

        if (is_null($image)) {
            throw new \yii\web\NotFoundHttpException(\Yii::t('common', 'Page not found'));
        }
        $thumbnail = Thumbnails::find()->where(['image_id' => $id])
            ->andWhere(['type' => Thumbnails::BIG_TYPE])->one();
        $tags = ImagesTags::find()
                ->select('tags.title, tags.translit_title')
                ->leftJoin('tags', 'tags.id = images_tags.tag_id')
                ->where(['images_tags.image_id' => $id])
                ->asArray()
                ->all();

        $description = Descriptions::find()->select('text')->where(['image_id' => $id])->one();
        $commentModel = new Comments();

        return $this->render('view', [
            'image' => $image,
            'thumbnail' => $thumbnail,
            'tags' => $tags,
            'description' => $description,
            'commentModel' => $commentModel
        ]);
    }
    
    public function actionSearch() 
    {   
        $searchModel = new ImagesSearch();
        $getData = Yii::$app->request->get();
        $dataProvider = $searchModel->search($getData);

        $searchModel->name = $getData['ImagesSearch']['name'];
        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }
    
    public function actionAddComment()
    {
        $model = new Comments();
        $model->created = date('Y-m-d H:i:s');
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', \Yii::t('common', 'Comment saved!'));
            } else {
                print_r($model->getErrors());die();
                \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($model->getErrors()));
            }
        } else {
            \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($model->getErrors()));
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
    
}

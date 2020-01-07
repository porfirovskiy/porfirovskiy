<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use backend\models\Images;
use backend\models\ImageUpdateForm;
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
    
    public function actionUpdate(int $id)
    {
        $image = Images::findOne($id);  
        $model = new ImageUpdateForm();
        //set standart fields
        $model->status = $image->status;
        $model->name = $image->name;
        $model->source = $image->source;
        //get tags
        $tags = ImagesTags::find()
                ->select('tags.title')
                ->leftJoin('tags', 'tags.id = images_tags.tag_id')
                ->where(['images_tags.image_id' => $image->id])
                ->asArray()
                ->all();
        $model->tags = ArrayHelper::getColumn($tags, 'title');
        //get description
        $model->description = isset($image->descriptions[0]) ? $image->descriptions[0]->text : null;
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->translit_name = \yii\helpers\Inflector::slug($model->name, '-');
            if ($model->update($id)) {
                Yii::$app->session->setFlash('success', \Yii::t('common', 'Image updated!'));
            } else {
                Yii::$app->session->setFlash('error', \Yii::t('common', 'Error: image not updated!'));
            }
        }
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
    
    public function actionTags(string $q) 
    {
        if (\Yii::$app->request->isAjax) {
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

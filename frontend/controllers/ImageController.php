<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use frontend\models\Images;
use frontend\models\Tags;
use frontend\models\Thumbnails;
use frontend\models\Exif;

class ImageController extends Controller
{
    public function actionUpload()
    {
        //echo sha1_file(__DIR__.'/ImageController.php');
        $model = new UploadForm();
        $request = Yii::$app->request;
        $model->load($request->post());
        if ($request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {                               
                //save image data to db
                $image = new Images();
                $image->name = $model->name;
                $image->translit_name = \yii\helpers\Inflector::slug($image->name, '-');
                $image->origin_name = $model->imageFile->baseName;
                $image->path = str_replace($model->dir, '', $model->imagePath);
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
                    echo 'saved!';
                } else {
                    echo 'error!';
                }
                die();
                //var_dump(date('Y-m-d H:i:s'));die();
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}

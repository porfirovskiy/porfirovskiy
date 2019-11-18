<?php

namespace frontend\controllers;

use frontend\models\Tags;
use frontend\models\Images;
use frontend\models\Thumbnails;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView(string $title)
    {
        
        $images = \Yii::$app->db->createCommand('
            SELECT i.name ,i.translit_name, i.id, t.path AS tpath FROM images i 
            JOIN thumbnails t ON t.image_id = i.id
            JOIN images_tags it ON it.image_id = i.id
            JOIN tags tg ON tg.id = it.tag_id
            WHERE tg.title=:title AND t.type=:type')
           ->bindValue(':title', $title)
           ->bindValue(':type', Thumbnails::SMALL_TYPE)
           ->queryAll();
        //echo '<pre>';var_dump($images);die();
        return $this->render('view', ['images' => $images, 'title' => $title]);
    }
    
    public function actionAutocomplete(string $q)
    {   
        if(\Yii::$app->request->isAjax) {
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

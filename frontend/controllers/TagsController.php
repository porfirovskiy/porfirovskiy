<?php

namespace frontend\controllers;

use frontend\models\Tags;
use frontend\models\Images;
use frontend\models\Thumbnails;
use yii\data\Pagination;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Tags::find()->select('title, translit_title');
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $tags = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->render('index', [
            'tags' => $tags,
            'pages' => $pages
        ]);
    }

    public function actionView(string $title)
    {
        $query = Images::find()
            ->select('images.name, images.translit_name, images.id, thumbnails.path')
            ->leftJoin('thumbnails', 'thumbnails.image_id = images.id')
            ->leftJoin('images_tags', 'images_tags.image_id = images.id')
            ->leftJoin('tags', 'tags.id = images_tags.tag_id')
            ->where(['tags.translit_title' => $title])
            ->andWhere(['thumbnails.type' => Thumbnails::SMALL_TYPE]);
       
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $images = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->render('view', [
            'images' => $images,
            'pages' => $pages,
            'title' => $title
        ]);
    }
    
    public function actionAutocomplete(string $q)
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

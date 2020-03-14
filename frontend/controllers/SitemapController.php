<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Tags;
use frontend\models\Images;
use frontend\models\Thumbnails;
use frontend\models\Pages;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SitemapController extends Controller
{
    public function actionIndex()
    {        
        $urls = [];
 
        //set static pages
        $urls[] = '/tags';
        $urls[] = '/site/about';
        $urls[] = '/site/contact';
        $urls[] = '/pages';
        
        //get images urls
        $images = Images::find()->select('id, translit_name')
                ->where(['status' => Images::PUBLIC_STATUS])->asArray()->all();
        foreach ($images as $image) {
            $urls[] = '/image/' . $image['id'] . '-' . $image['translit_name'];
        }
        
        //get tags urls
        $tags = Tags::getTagsQuery()->andWhere(['not', ['tags.translit_title' => null]])->asArray()->all();
        foreach ($tags as $tag) {
            $urls[] = '/tag/' . $tag['translit_title'];
        }
        
        //get pages urls
        $pages = Pages::find()->select('id, translit_title')
                ->where(['status' => Pages::PUBLIC_STATUS])->asArray()->all();
        foreach ($pages as $page) {
            $urls[] = '/pages/' . $page['id'] . '-' . $page['translit_title'];
        }
        
        //set content type xml in response
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        
        return $this->renderPartial('index', [
            'host' => \Yii::$app->request->hostInfo,
            'urls' => $urls
        ]);        
    }
    
    public function actionImages()
    {
        $urls = [];
        
        //get images
        $images = Images::find()
                    ->select([
                        'images.name',
                        'thumbnails.path', 
                        new \yii\db\Expression("CONCAT('/image/', images.id, '-', images.translit_name) as url")
                    ])
                    ->innerJoin('thumbnails', 'thumbnails.image_id = images.id')
                    ->where(['images.status' => Images::PUBLIC_STATUS])
                    ->andWhere(['thumbnails.type' => Thumbnails::BIG_TYPE])
                    ->asArray()
                    ->all();
        
        //set content type xml in response
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        
        return $this->renderPartial('images', [
            'host' => \Yii::$app->request->hostInfo,
            'images' => $images
        ]);        
    }
}
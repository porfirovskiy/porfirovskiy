<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Tags;
use frontend\models\Images;

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
        
        //get images urls
        $images = Images::find()->select('id, translit_name')->where(['status' => Images::PUBLIC_STATUS])->asArray()->all();
        foreach ($images as $image) {
            $urls[] = '/image/' . $image['id'] . '-' . $image['translit_name'];
        }
        
        //get tags urls
        $tags = Tags::find()->select('translit_title')->where(['not', ['translit_title' => null]])->asArray()->all();
        foreach ($tags as $tag) {
            $urls[] = '/tag/' . $tag['translit_title'];
        }

        //echo '<pre>';var_dump($urls);die();
        
        
        /*$xml = new \yii\web\XmlResponseFormatter;
        $xml->rootTag = false;
        \Yii::$app->response->format = 'custom_xml';
        \Yii::$app->response->formatters['custom_xml'] = $xml;*/
 
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        //\Yii::$app->response->formatters['xml']['rootTag'] = null;
        
        return $this->renderPartial('index', array(
            'host' => \Yii::$app->request->hostInfo,
            'urls' => $urls
        ));        
    }
}
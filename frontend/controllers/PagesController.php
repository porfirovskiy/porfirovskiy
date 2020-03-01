<?php

namespace frontend\controllers;



class PagesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Tags::getTagsQuery();
        
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


}

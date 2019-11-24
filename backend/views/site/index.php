<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Thumbnails;

$this->title = 'List of images';
?>
<div class="site-index">
    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                'id',
                'created',
                'name',
                [
                    'attribute' => 'tags',
                    'value' => function ($data) {
                        $thumbnail = \yii\helpers\ArrayHelper::getColumn($data->thumbnails, function ($element) {
                            if ($element['type'] == Thumbnails::SMALL_TYPE) {
                                return $element['path'];
                            }
                        });
                        $host = 'http://img.net/';
                        return Html::a(Html::img($host . $thumbnail[0]), $host . 'image/' . $data->id . '-' . $data->translit_name);
                    },
                    'format' => 'raw',
                ],    
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Действия', 
                    'headerOptions' => ['width' => '80'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,$model) {
                             return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/image/update&id=' . $model->id]);
                        },
                        'delete' => function ($url,$model) {
                            return urldecode(Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                                    ['/image/delete&id=' . $model->id],
                                    [
                                        'data' => [
                                            'confirm' => 'Delete image?',
                                            //'method' => 'post',
                                        ]
                                    ]));
                        }
                    ],
                ],
                /*[
                    'attribute' => 'created',
                    'value' => function ($data) {
                        return $data->created;
                    },
                    'format' => 'raw',
                ],*/           
            ],
        ]);
    ?>
</div>

<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'List of images';
?>
<div class="site-index">
    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'created',
                'title',
                'status',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Действия', 
                    'headerOptions' => ['width' => '80'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                             return urldecode(Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/pages/update&id=' . $model->id]));
                        },
                        'delete' => function ($url, $model) {
                            return urldecode(Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                                    ['/pages/delete&id=' . $model->id],
                                    [
                                        'data' => [
                                            'confirm' => 'Delete page?',
                                            //'method' => 'post',
                                        ]
                                    ]));
                        }
                    ],
                ],          
            ],
        ]);
    ?>
</div>

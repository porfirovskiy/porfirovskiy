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

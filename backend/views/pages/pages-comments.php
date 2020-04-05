<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\Images;

$this->title = 'List of pages comments';
?>
<div class="site-index">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'comment',
            [
                'attribute' => 'page',
                'value' => function ($model, $key, $index, $column) {
                    $page = $model->page;
                    $host = (new Images())->getHost();
                    return Html::a($page->title, $host . 'pages/' . $page->id . '-' . $page->translit_title);
                },
                'format' => 'raw'
            ],
            'created'
        ],
    ]);
    ?>
</div>

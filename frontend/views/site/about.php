<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::t('common', 'About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <br>
    <p>
        На этом сайте я размещаю изображения которые мне интересны.
    </p>
    
    <p>
        Также публикую заметки на разную тематику.
    </p>
    
    <p>
        Почта для связи: <a href="mailto:porfirovskiy@gmail.com">porfirovskiy@gmail.com</a>
    </p>

</div>

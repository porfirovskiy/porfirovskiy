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
        Сайт создан для хранения изображений и показу их пользователям.
    </p>
    <p>
        Изображения привязаны к тегам, что дает привязку к определенной тематике.
    </p>

</div>

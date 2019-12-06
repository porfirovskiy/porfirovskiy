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
        Сайт создан как авторский проект хранилища изображений на разную тематику. 
    </p>
    <p>
        Скриншоты из игр, фильмов, обычные фото и прочие изображения.
    </p>

</div>

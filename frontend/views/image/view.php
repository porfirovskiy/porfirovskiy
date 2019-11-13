<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::t('common', 'View image');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <br>
    <div style="text-align: center;">
        <?= Html::img('@web/' . $thumbnail->path, ['alt' => 'Наш логотип']) ?>
    </div>
    <?= Html::a(\Yii::t('common', 'Full size'), ['@web/images/' . $image->path]) ?>

</div>

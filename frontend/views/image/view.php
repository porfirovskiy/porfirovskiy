<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $image->name;
$this->params['breadcrumbs'][] = \Yii::t('common', 'Images');
$this->params['breadcrumbs'][] = $this->title;
?>

  <style>
      .image {
          text-align: center;
      }
    .image-params {
        color: gray;
    }
    .image-params-wrapper {
        text-align: left;
    }
    .image-description {
        text-align: justify;
        display: inline-block;
    }
    .params-main-wrapper {
        width: 70%;
        margin: 0 auto;
    }
    .image-description-wrapper {
        width: 70%;
        margin: 0 auto;
    }
  </style>

<div class="site-about">

    <h1 class="image"><?= Html::encode($image->name) ?></h1>

    <div class="image">
        <?= Html::img('@web/' . $thumbnail->path, ['alt' => 'Наш логотип']) ?>
    </div>
    
    <br>
    <div class="params-main-wrapper">
        <div class="image-params-wrapper">
            <?= Html::a(\Yii::t('common', 'Full size'), ['@web/images/' . $image->path]) ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params"><?=\Yii::t('common', 'Source')?>:</span> <?= $image->source ? $image->source : 'empty' ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params">
                <?=\Yii::t('common', 'Tags')?>:
            </span>
            <?php foreach($tags as $tag): ?>
            <?= Html::a($tag, ['@web/tags/' . $tag]) ?>
            <?php endforeach; ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params"><?=\Yii::t('common', 'Width x Hight')?>:</span> <?= $image->width . 'x' . $image->hight ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params"><?=\Yii::t('common', 'Size in Kb')?>:</span> <?= round($image->size/1024) ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params"><?=\Yii::t('common', 'Origin name')?>:</span> <?= $image->origin_name ?>
        </div>
    </div>
    
    <br>
    <div class="image-description-wrapper">
        <span class="image-params"><?=\Yii::t('common', 'Description')?>:</span>
        <br>
        <span class="image-description">
            <?= $description->text ?>
        </span>
    </div>

</div>

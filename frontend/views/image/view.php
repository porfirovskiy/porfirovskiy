<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $image->name;
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
        <?= Html::img('@web/' . $thumbnail->path, [
            'alt' => $image->name,
            'title' => $image->name,
            'width' => $thumbnail->width,
            'hight' => $thumbnail->hight
        ]) ?>
    </div>
    
    <br>
    <div class="params-main-wrapper">
        <div class="image-params-wrapper">
            <?= Html::a(\Yii::t('common', 'Full size'), ['@web/images/' . $image->path]) ?>
        </div>
        
        <div class="image-params-wrapper">
            <span class="image-params"><?=\Yii::t('common', 'Created')?>:</span> <?= $image->created ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params"><?=\Yii::t('common', 'Source')?>:</span> <?= $image->source ? $image->source : 'original' ?>
        </div>

        <div class="image-params-wrapper">
            <span class="image-params">
                <?=\Yii::t('common', 'Tags')?>:
            </span>
            <?php foreach($tags as $tag): ?>
            <?= Html::a($tag, ['@web/tag/' . $tag]) ?>
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
            <?= isset($description->text) ? $description->text : 'нету' ?>
        </span>
    </div>
    
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif;?>
    
    <div class="image-comment-form">
        <?= $this->render('_comment_form', [
                'commentModel' => $commentModel,
                'imageId' => $image->id 
            ]) ?>
    </div>
    
    <div class="image-comment-form">
            <?= $this->render('_comments_list', [
                'model' => $image
            ]) ?>
    </div>

</div>

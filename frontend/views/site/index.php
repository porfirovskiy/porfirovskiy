<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('common', 'Img.net');
?>

  <style>
    .wrap-small-image {
        text-align: center;
      }
    
    .small-image {
        display: inline-block;
        width: 20%;
        text-align: center;
    }
  </style>

<div class="site-index">

    <div class="body-content">

        <div class="image-search">
                <?php $form = ActiveForm::begin([
                    'id' => 'image-search-form',
                    'method' => 'get',
                    'action' => ['/image/search']
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="wrap-small-image">
            <?php foreach($randomImages as $image): ?>
                <div class="small-image">
                    <?= Html::img('@web/' . $image->path, ['alt' => $image->name]) ?>
                    <br>
                    <?= Html::a($image->name, ['image/' . $image->id . '-' . $image->translit_name]) ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

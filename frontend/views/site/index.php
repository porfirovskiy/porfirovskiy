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
    
    .image-search {
        text-align: center;
        margin-bottom: 5%;
    }
    
    .image-search input {
        width: 30%;
        display: inline-block;
    }
    
  </style>

<div class="site-index">

    <div class="body-content">

        <div class="image-search">
            <?= $this->render('/image/_search_form', ['model' => $model]) ?>
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

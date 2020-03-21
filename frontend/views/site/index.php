<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('common', 'Portal of images - karkaron.com');
?>

  <style>
    .wrap-small-image {
        text-align: center;
      }
    
    .small-image {
        display: inline-block;
        width: 20%;
        text-align: center;
        margin-bottom: 2%;
    }
    
    .image-search {
        text-align: center;
        margin-bottom: 1%;
    }
    
    .image-search input {
        width: 30%;
        display: inline-block;
    }
    
    .tag {
        display: inline-block;
        border: 1px dotted green;
        padding: 5px;
        font-size: 16px;
        margin: 4px;
     }

    @media (max-width: 1220px) {
        .small-image {
            width: 30%;
        }
    }

    @media (max-width: 760px) {
        .small-image {
            width: 40%;
        }
    }

    @media (max-width: 650px) {
        .small-image {
            width: 55%;
        }
    }

  </style>

<div class="site-index">

    <div class="body-content">

        <div class="image-search">
            <?= $this->render('/image/_search_form', ['model' => $model]) ?>
        </div>
        
        <div style="padding: 1%;margin-bottom: 1%;text-align: center;">
            <?php foreach($randomTags as $tag): ?>
                <div class="tag">
                    <?= Html::a($tag->title, ['tag/' . $tag->translit_title]) ?>
                </div>
            <?php endforeach; ?>
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

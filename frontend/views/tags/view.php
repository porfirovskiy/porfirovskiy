<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = \Yii::t('common', 'tag') . ': ' . $title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'Tags'), 'url' => '/tags'];
$this->params['breadcrumbs'][] = $title;

?>

  <style>
    .tag {
        display: inline-block;
      }
      
    .tag-name {
        display: inline-block;
        color: green;
    }

    .tag-wrap {
        text-align: center;
        margin-bottom: 4%;
    }
    
    .small-image {
        display: inline-block;
        width: 20%;
        text-align: center;
        margin-bottom: 2%;
    }
    
    .tag-images-wrap {
        text-align: center;
    }
    
    .pager-wrap {
        text-align: center;
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

  <div class="tag-wrap">
      <div class="tag"><?= \Yii::t('common', 'tag') ?></div>:
      <h1 class="tag-name"> <?= $title ?></h1>
  </div>

<div class="tag-images-wrap">
    <?php foreach($images as $image): ?>
        <div class="small-image">
            <?= Html::img('@web/' . $image->path, ['alt' => $image->name]) ?>
            <br>
            <?= Html::a($image->name, ['image/' . $image->id . '-' . $image->translit_name]) ?>
        </div>
    <?php endforeach; ?>
</div>
    
<div class="pager-wrap">  
    <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
    ?>
</div>

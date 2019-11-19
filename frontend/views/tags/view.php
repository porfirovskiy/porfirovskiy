<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;


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
    }
    
    .small-image {
        display: inline-block;
        width: 20%;
        text-align: center;
    }
  </style>

  <div class="tag-wrap">
      <div class="tag"><?= \Yii::t('common', 'tag') ?></div>:
      <h1 class="tag-name"> <?= $title ?></h1>
  </div>

<div>
    <?php foreach($images as $image): ?>
        <div class="small-image">
            <?= Html::img('@web/' . $image->path, ['alt' => $image->name]) ?>
            <br>
            <?= Html::a($image->name, ['image/' . $image->id . '-' . $image->translit_name]) ?>
        </div>
    <?php endforeach; ?>
</div>
    
<?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
?>

<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = \Yii::t('common', 'Tags');
$this->params['breadcrumbs'][] = $this->title;

?>

  <style>
    .tag {
        display: inline-block;
        border: 1px dotted green;
        padding: 5px;
        font-size: 16px;
        margin: 4px;
     }
     
    .tag-wrap {
        text-align: center;
    }
    
    .pagination-wrapper {
        text-align: center;
    }
  </style>

  <div class="tag-wrap">
      <h1> <?= \Yii::t('common', 'Tags') ?>:</h1>
  </div>

<div style="padding: 1%;text-align: center;">
    <?php foreach($tags as $tag): ?>
        <div class="tag">
            <?= Html::a($tag->title, ['tag/' . $tag->title]) ?>
        </div>
    <?php endforeach; ?>
</div>
    
<div class="pagination-wrapper">
    <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
    ?>
</div>

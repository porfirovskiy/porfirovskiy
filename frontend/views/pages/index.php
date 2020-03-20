<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = \Yii::t('common', 'Pages');
$this->params['breadcrumbs'][] = $this->title;

?>

  <style>
    .tag {
        padding: 5px;
        font-size: 16px;
     }
     
    .tag-wrap {
        text-align: center;
    }
    
    .pagination-wrapper {
        text-align: center;
    }
  </style>

  <div class="tag-wrap">
      <h1> <?= \Yii::t('common', 'Pages') ?>:</h1>
  </div>

<div style="margin-top: 4%;">
    <?php foreach($pagesList as $page): ?>
        <div class="tag">
            <?= Html::a($page->title, ['pages/' . $page->id . '-' . $page->translit_title]) ?>
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

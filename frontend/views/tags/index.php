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
     }
     
    .tag-wrap {
        text-align: center;
    }
  </style>

  <div class="tag-wrap">
      <h1> <?= \Yii::t('common', 'Tags') ?>:</h1>
  </div>

<div>
    <?php foreach($tags as $tag): ?>
        <div class="tag">
            <?= Html::a($tag->title, ['tag/' . $tag->title]) ?>
        </div>
    <?php endforeach; ?>
</div>
    
<?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
?>

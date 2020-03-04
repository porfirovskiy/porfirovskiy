<?php
use yii\helpers\Html;

$this->title = $page->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'Pages'), 'url' => '/pages'];
$this->params['breadcrumbs'][] = $this->title;
?>

  <style>
    .page-wrapper {
        text-align: center;
    }
    
    .page-wrapper .row {
        text-align: justify;
        width: 70%;
        display: inline-block;
    }
  </style>

<div class="page-wrapper">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <br>
    
    <div class="row">
            <?= nl2br($page->content); ?>
    </div>

</div>
<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $image->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

    <h1 style="text-align: center;"><?= Html::encode($image->name) ?></h1>

    <div style="text-align: center;">
        <?= Html::img('@web/' . $thumbnail->path, ['alt' => 'Наш логотип']) ?>
    </div>
    
    <div style="text-align: center;">
        <?= Html::a(\Yii::t('common', 'Full size'), ['@web/images/' . $image->path]) ?>
    </div>
        
    <div style="text-align: center;">
        Source: <?= $image->source ?>
    </div>
    
    <div style="text-align: center;">
        Tags:
        <?php foreach($tags as $tag): ?>
        <?= Html::a('#' . $tag, ['@web/tag/' . $tag]) ?>
        <?php endforeach; ?>
    </div>
    
    <div style="text-align: center;">
        Width x Hight: <?= $image->width . 'x' . $image->hight ?>
    </div>
   
    <div style="text-align: center;">
        Size in bytes: <?= $image->size ?>
    </div>
    
    <div style="text-align: center;">
        Origin name: <?= $image->origin_name ?>
    </div>
    
    <div style="text-align: center;">
        Description:
        <br>
        <?= $description->text ?>
    </div>

</div>

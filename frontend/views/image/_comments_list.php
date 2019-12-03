<?php

use yii\helpers\Html;

?>

<div>
    <?php foreach($model->comments as $comment): ?>
        <div>
            <div class="image-comment-name">
                <?= \Yii::t('common', 'Name') ?>: <?= $comment->name ?> <?= \Yii::t('common', 'added') ?>: <?= $comment->created ?>
            </div>
            <div class="image-comment">
                <?= $comment->comment ?>
            </div>
        </div>
    <?php endforeach; ?>
</div> 
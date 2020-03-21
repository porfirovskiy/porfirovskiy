<?php

use yii\helpers\Html;

?>

<style>
    
    .image-comment-name {
        text-align: left;
    }
    
    .image-comment-name span {
        color: gray;
        
    }
    
    .image-comment-name b {
        color: lightseagreen;
    }
    
    .image-comment-name .date {
       color: black;
    }
    
   .image-comment {
        text-align: justify;
    }
    
    .image-comment-wrapper {
        margin-bottom: 2%;
    }
    
</style>

<div>
    <?php foreach($model->pageComments as $comment): ?>
        <div class="image-comment-wrapper">
            <div class="image-comment-name">
                <b><?=  (empty($comment->name)) ? 'anonymous': $comment->name ?></b>
                <span><?= \Yii::t('common', 'added') ?>:</span> <span class="date"><?= $comment->created ?></span>
            </div>
            <div class="image-comment">
                <?= nl2br($comment->comment) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div> 
<?php

use yii\helpers\Html;

?>

<div>
    <?php foreach($model->comments as $comment): ?>
        <div>
            <div class="image-comment-name">
                Name: <?= $comment->name ?>
            </div>
            <div class="image-comment">
                Comment: <?= $comment->comment ?>
            </div>
            <div class="image-comment-created">
                Created: <?= $comment->created ?>
            </div>
        </div>
    <?php endforeach; ?>
</div> 
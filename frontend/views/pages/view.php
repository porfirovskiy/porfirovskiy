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
    
    .image-comment-list {
        width: 70%;
    }
    
    .image-wrapper img {
        max-width: 100%;
    }
    
    .page-wrapper .row p {
        text-align: justify;
        width: 70%;
        display: inline-block;
    }

    .image-comment-form input {
        width: 250px;
    }

    @media (min-width: 800px) {
        .image-comment-form {
            width: 40%;
        }
    }

    @media (min-width: 500px) {
        .image-comment-form {
            width: 60%;
        }

        .image-comment-list {
            width: 90%;
        }
    }

    @media (max-width: 800px) {
        .page-wrapper .row p {
            text-align: left;
            width: 90%;
        }

        .image-comment-list {
            width: 90%;
        }
    }

  </style>

<div class="page-wrapper">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <br>
    
    <div class="row">
            <?= $page->content; ?>
    </div>

</div>

<br><br>

<div class="image-comment-form">
    <div><h4><?=\Yii::t('common', 'Add comment')?></h4></div>
    <?= $this->render('_comment_form', [
        'commentModel' => $commentModel,
        'pageId' => $page->id
    ]) ?>
</div>

<br><br>

<h4><?=\Yii::t('common', 'Comments')?>:</h4>
<div class="image-comment-list">
    <hr>
    <?= $this->render('_comments_list', [
        'model' => $page
    ]) ?>
</div>
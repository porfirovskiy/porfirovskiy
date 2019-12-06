<?php
    use yii\widgets\ListView;
?>

<style>
    .images-wrapper div[data-key] {
        display: inline-block;
        width: 20%;
    }
    
    .images-wrapper {
        text-align: center;
    }
    
    .image-search {
        text-align: center;
    }
    
    .image-search input {
        width: 30%;
        display: inline-block;
    }
    
    .summary-search {
        color: gray;
        margin-bottom: 1%;
    }
    
    .pagerony {
        text-align: center;
    }
    
    .images-wrapper .image {
        padding-bottom: 5%;
    }
</style>

<h2>Search</h2>

<div class="image-search">
    <?= $this->render('_search_form', ['model' => $model]) ?>
</div>

<div class="images-wrapper">
    <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_image',
            'layout' => "<div class='pagerony'>{pager}</div>\n{summary}\n{items}\n<div class='pagerony'>{pager}</div>",
            'summary' => '<div class="summary-search">Showing <b>{count}</b> of <b>{totalCount}</b> images</div>'
        ]);
    ?>
</div>
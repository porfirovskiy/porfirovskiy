<?php
    use yii\widgets\ListView;
?>

<style>
    .images-wrapper div[data-key] {
        display: inline-block;
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
            'layout' => "{pager}\n{summary}\n{items}\n{pager}",
            'summary' => '<div class="summary-search">Showing <b>{count}</b> of <b>{totalCount}</b> images</div>'
        ]);
    ?>
</div>
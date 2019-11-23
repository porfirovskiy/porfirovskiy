<?php
    use yii\widgets\ListView;
?>

<style>
    .images-wrapper div[data-key] {
        display: inline-block;
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
        ]);
    ?>
</div>
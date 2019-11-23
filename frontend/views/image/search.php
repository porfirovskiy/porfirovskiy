<?php
    use yii\widgets\ListView;
?>

<div class="image-search">
    <?= $this->render('_search_form', ['model' => $model]) ?>
</div>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_image',
]);

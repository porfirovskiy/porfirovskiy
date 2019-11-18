<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

?>
Tag <h1> <?= $title ?></h1>

<?php foreach($images as $image): ?>
    <div class="image">
        <?= Html::img('@web/' . $image['tpath'], ['alt' => 'Наш логотип']) ?>
        <br>
        <?= Html::a(\Yii::t('common', $image['name']), ['image/' . $image['id'] . '-' . $image['translit_name']]) ?>
    </div>
<?php endforeach; ?>

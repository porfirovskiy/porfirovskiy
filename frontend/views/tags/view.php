<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;


?>
Tag <h1> <?= $title ?></h1>

<?php foreach($images as $image): ?>
    <div class="image">
        <?= Html::img('@web/' . $image->path, ['alt' => 'Наш логотип']) ?>
        <br>
        <?= Html::a(\Yii::t('common', $image->name), ['image/' . $image->id . '-' . $image->translit_name]) ?>
    </div>
<?php endforeach; ?>

<?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
?>

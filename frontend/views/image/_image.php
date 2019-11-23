<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\models\Thumbnails;
?>

<div class="image">
    
    <?php
        $thumbnail = \yii\helpers\ArrayHelper::getColumn($model->thumbnails, function ($element) {
            if ($element['type'] == Thumbnails::SMALL_TYPE) {
                return $element['path'];
            }
        });
    ?>
    
    <div class="tag">
        <?= Html::img('@web/' . $thumbnail[0], ['alt' => $model->name]) ?>
        <br>
        <?= Html::a($model->name, ['image/' . $model->id . '-' . $model->translit_name]) ?>
    </div>

</div>
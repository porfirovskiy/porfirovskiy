<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'image-search-form',
        'method' => 'get',
        'action' => ['/image/search']
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'id' => 'image-comment-form',
    'method' => 'get',
    'action' => ['/comment/add']
]); ?>

    <?= $form->field($commentModel, 'name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($commentModel, 'comment')->textarea(['rows' => '3']) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('common', 'Add'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
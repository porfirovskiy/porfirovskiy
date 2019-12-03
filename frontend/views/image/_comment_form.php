<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'id' => 'image-comment-form',
    'method' => 'post',
    'action' => ['/image/add-comment']
]); ?>

    <?= $form->field($commentModel, 'name')->textInput(['autofocus' => true, 'placeholder' => \Yii::t('common', 'Name')])->label(false) ?>

    <?= $form->field($commentModel, 'comment')->textarea(['rows' => '3', 'placeholder' => \Yii::t('common', 'Comment')])->label(false) ?>

    <?= $form->field($commentModel, 'image_id')->hiddenInput(['value' => $imageId])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('common', 'Add'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
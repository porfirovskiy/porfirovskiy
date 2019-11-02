<?php
    use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>

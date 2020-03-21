<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\captcha\Captcha;
?>

<?php $form = ActiveForm::begin([
    'id' => 'image-comment-form',
    'method' => 'post',
    'action' => ['/pages/add-comment']
]); ?>

    <?= $form->field($commentModel, 'name')->textInput(['autofocus' => false, 'placeholder' => \Yii::t('common', 'Optional name')])->label(false) ?>

    <?= $form->field($commentModel, 'comment')->textarea(['rows' => '3', 'placeholder' => \Yii::t('common', 'Comment')])->label(false) ?>

    <?= $form->field($commentModel, 'page_id')->hiddenInput(['value' => $pageId])->label(false); ?>

     <?= $form->field($commentModel, 'reCaptcha')->widget(
        \himiklab\yii2\recaptcha\ReCaptcha2::className(),
        [
            'siteKey' => '6LehA-MUAAAAAJsW185tgYm6axua8AHfh3Oio7GS', // unnecessary is reCaptcha component was set up
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('common', 'Add'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Pages;

$this->title = Yii::t('common', 'Update page');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    #pageform-status {
        width: 20%;
    }
    
    #pageform-title {
        width: 70%;
    }
    #pageform-content {
        width: 70%;
    }
</style>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="wrapper">
            <?php $form = ActiveForm::begin(['id' => 'page-form']); ?>
            
                <?= $form->field($model, 'status')->dropDownList([
                        'public' => Pages::PUBLIC_STATUS,
                        'private' => Pages::PRIVATE_STATUS
                    ]); 
                ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'content')->textarea(['rows' => '20']) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('common', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'page-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

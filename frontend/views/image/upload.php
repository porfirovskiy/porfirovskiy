<?php
    use yii\widgets\ActiveForm;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use yii\helpers\Url;
    use frontend\models\Images;
    use frontend\models\UploadForm;
?>
<div class="load-form">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([ 
                    'options' => [
                        'enctype' => ($formType == UploadForm::FORM_TYPE_FILE) ? 'multipart/form-data' : 'application/x-www-form-urlencoded'
                    ]
                ]) ?>

                <?php if ($formType == UploadForm::FORM_TYPE_FILE): ?>
                    <?= $form->field($model, 'imageFile')->fileInput() ?>
                <?php else: ?>
                    <?= $form->field($model, 'imageUrl') ?>
                <?php endif; ?>
            
                <?= $form->field($model, 'status')->dropDownList([
                        'public' => Images::PUBLIC_STATUS,
                        'private' => Images::PRIVATE_STATUS
                    ]); 
                ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'source') ?>
            
                <?=
                    $form->field($model, 'tags')->widget(Select2::classname(), [
                        'name' => 'tags',
                        'options' => [
                            'placeholder' => 'input tags',
                            'multiple' => true,
                        ],
                        'data' => ['id' => 1, 'name' => 'test'],
                        'pluginOptions' => [
                            'tags' => true,
                            'initialize' => true,
                            'allowClear' => true,
                            'minimumInputLength' => 2,
                            'maximumSelectionLength' => 15,
                            'ajax' => [
                                'url' => Url::to('/tags/autocomplete'),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                'processResults' => new JsExpression('function(data) {
                                    return {
                                      results: $.map(data, function(obj) {
                                        return {
                                          id: obj.id,
                                          text: obj.text
                                        };
                                      })
                                    };
                                  }'),
                            ]
                        ]
                    ])
                ?>

                <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

                <button>Submit</button>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
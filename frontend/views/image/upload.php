<?php
    use yii\widgets\ActiveForm;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    
    <?= $form->field($model, 'name') ?>

    
<?=
    $form->field($model, 'tags')->widget(Select2::classname(), [
        'name' => 'tags',
        'options' => [
            'placeholder' => 'input tags',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'tags' => true,
            'allowClear' => true,
            'minimumInputLength' => 3,
            'maximumSelectionLength' => 3,
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

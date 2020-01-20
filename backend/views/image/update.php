<?php
    use yii\widgets\ActiveForm;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use yii\helpers\Url;
    use frontend\models\Images;
    use frontend\models\Thumbnails;
    use yii\helpers\Html;
?>
<div class="load-form">
    <div class="row">
        <div class="col-lg-5">
            
            <h4>Picture</h4>
            
            <?php 
                 $thumbnail = \yii\helpers\ArrayHelper::getColumn($image->thumbnails, function ($element) {
                     if ($element['type'] == Thumbnails::SMALL_TYPE) {
                         return $element['path'];
                     }
                 });

                echo Html::img($thumbnail[0]);
            ?>
            
            <br><br>
            
            <?php $form = ActiveForm::begin([
                    //'enableAjaxValidation' => true,
                ]) ?>

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
                        //'data' => ['id' => 1, 'name' => 'test'],
                        'pluginOptions' => [
                            'tags' => true,
                            'initialize' => true,
                            'allowClear' => true,
                            'minimumInputLength' => 2,
                            'maximumSelectionLength' => 15,
                            'ajax' => [
                                'url' => Url::to('index.php?r=image/tags'),
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

                <button>Update</button>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
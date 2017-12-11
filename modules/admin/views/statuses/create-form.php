<?php

use yii\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['statuses/create'],
    'options' => ["enctype" => "multipart/form-data", 'class' => 'form-inline', 'id' => 'newForm']

]); ?>

<?= $form->field($model, 'description',
    [
        'options' => ['class' => 'form-group form-md-line-input'],
        'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
        'inputOptions' => ['class' => 'form-control']
    ])
    ->textInput(['required' => true, 'placeholder' => 'Status Description'])
    ->label(false)
    ->hint('Status Description.')
?>


    <button type="button" class="btn green" onclick="save('#newForm')"> Save</button>
    <a data-toggle="collapse" data-parent="#accordion1" href="#accordion_create" aria-expanded="false"
       class="btn default accordion-toggle collapsed company-form-cancel"> Cancel </a>

<?php ActiveForm::end(); ?>
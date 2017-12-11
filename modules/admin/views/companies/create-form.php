<?php

use yii\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['companies/create'],
    'options' => ["enctype" => "multipart/form-data",
        //'class' => 'form-inline',
        'id' => 'newForm']

]); ?>

<?= $form->field($model, 'company_name',
    [
        'options' => ['class' => 'form-group'],
        'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
        'inputOptions' => ['class' => 'form-control']
    ])
    ->textInput(['required' => true, 'placeholder' => 'Company Name'])
    ->label(false)
    ->hint('Company name.')
?>

    <div class="form-group">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"
                 style="max-width: 200px; max-height: 150px;"></div>

            <div>
                <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                    <div class="form-group field-company-profile_picture">

                        <input type="hidden" name="Company[profile_picture]" value="">
                        <input type="file" id="company-profile_picture" name="Company[profile_picture]">

                        <p class="help-block help-block-error"></p>
                    </div> </span>
                <a href="javascript:" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>
    </div>

    <button type="submit" class="btn green"> Save</button>
    <a data-toggle="collapse" data-parent="#accordion1" href="#accordion_create" aria-expanded="false"
       class="btn default accordion-toggle collapsed company-form-cancel"> Cancel </a>

<?php ActiveForm::end(); ?>
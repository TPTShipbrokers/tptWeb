<?php

use app\models\Chartering;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(['options' => ["enctype" => "multipart/form-data"]]); ?>

    <?php
    $rows = array_values(Chartering::find()->joinWith('vessel')->asArray()->all());

    $chartering = [];
    array_map(function ($el) use (&$chartering) {
        return $chartering[$el['chartering_id']] = $el['vessel_name'];
    }, $rows);
    ?>
    <?= $form->field($model, 'chartering_id')->dropDownList($chartering, ['prompt' => '', 'onchange' => 'getCharteringDetails(this)'])->label('Chartering') ?>
    <div id="chartering_details"></div>

    <?= $form->field($model, 'invoice_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fixture_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp_date')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->cp_date))]) ?>


    <?= $form->field($model, 'freight')->textInput(['type' => 'number', 'step' => '0.1']) ?>

    <?= $form->field($model, 'commission_percentage')->textInput() ?>

    <?= $form->field($model, 'VAT')->textInput(['type' => 'number', 'step' => '0.1']) ?>

    <?= $form->field($model, 'total')->textInput(['type' => 'number', 'step' => '0.1']) ?>

    <?= $form->field($model, 'status')->dropDownList(['pending' => 'Pending', 'paid' => 'Paid', 'overdue' => 'Overdue',], ['prompt' => '']) ?>
    <div style="position:relative">
        <?= $form->field($model, 'due_date')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->due_date))]) ?>

    </div>
    <div style="position:relative">
        <?= $form->field($model, 'start_period')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->start_period))]) ?>
    </div>
    <div style="position:relative">
        <?= $form->field($model, 'end_period')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->end_period))]) ?>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"> Invoice PDF </label>
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">

                <?php if ($model->file): ?>
                    <div id="ship_doc_row">
                        <a class="btn btn-sm grey-salsa btn-outline"
                           href="#ship_doc_<?= $model->filename ?>"
                           data-toggle="collapse"
                           target="_blank"
                           class="btn green  btn-outline accordion-toggle collapsed" aria-expanded="false"
                        >
                            <?= $model->filename ? $model->filename : "View Document" ?>
                        </a>
                    </div>
                <?php else: ?>

                <?php endif; ?>
                <?php /*if(!empty($model->invoiceDocumentations)): ?>

                        <div class="update-pane">

                            <div class="form-group">
                                <?php foreach($model->invoiceDocumentations as $doc): ?>
                                    <div id="ship_doc_row<?=$doc->invoice_documentation_id?>">
                                        <a class="btn btn-sm grey-salsa btn-outline"
                                           href="#ship_doc_<?=$doc->invoice_documentation_id?>"
                                           data-toggle="collapse"
                                           target="_blank"
                                           class="btn green  btn-outline accordion-toggle collapsed"  aria-expanded="false"
                                        >
                                            <?=$doc->filename?$doc->filename:"View Document"?>
                                        </a>
                                        <p id="ship_doc_<?=$doc->invoice_documentation_id?>"
                                           class="panel-collapse collapse"
                                           aria-expanded="false"
                                        >
                                            <a class="btn btn-success" href="<?=Yii::$app->request->baseUrl . '/' . $doc->file?>"
                                               target="_blank"> View document
                                            </a>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="label label-danger">not ready</span>
                    <?php endif; */ ?>
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"
                 style="max-width: 200px; max-height: 150px;"></div>

            <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <?= $form->field($model, 'invoice_documentations')->fileInput(['multiple' => true])->label
                        (false) ?> </span>
                <a href="javascript:" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<script>

    function getCharteringDetails(el) {

        var option = $(el).find('option:selected').val();
        $.post("<?=Url::toRoute('chartering/details/')?>/" + option, {}, function (data) {
            $('#chartering_details').html(data);
        });
    }

    $(document).ready(function () {
        Main.initDatetimePicker(".form_datetime_status");
    });


</script>

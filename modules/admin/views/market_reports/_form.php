<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Newsletter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="newsletter-form">

    <?php $form = ActiveForm::begin(['options' => ["enctype" => "multipart/form-data"]]); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'date')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->date))]) ?>


    <div class="form-group">
        <label class="col-md-3 control-label"> PDF </label>
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <?php if ($model->file): ?>

                <embed src="<?= Url::home(true) ?><?= $model->file ?>" type='application/pdf'>
                    <?php endif; ?>
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"
                 style="max-width: 200px; max-height: 150px;"></div>

            <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <?= $form->field($model, 'file')->fileInput()->label(false) ?> </span>
                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>


<script>
    $(document).ready(function () {
        Main.initDatetimePicker(".form_datetime_status");
    });

</script>

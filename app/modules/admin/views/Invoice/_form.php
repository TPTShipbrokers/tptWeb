<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'chartering_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fixture_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp_date')->textInput() ?>

    <?= $form->field($model, 'freight')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'commission_percentage')->textInput() ?>

    <?= $form->field($model, 'VAT')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'pending' => 'Pending', 'payed' => 'Payed', 'overdue' => 'Overdue', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'due_date')->textInput() ?>

    <?= $form->field($model, 'start_period')->textInput() ?>

    <?= $form->field($model, 'end_period')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

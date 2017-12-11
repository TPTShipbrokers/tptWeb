<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InvoicesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'invoice_id') ?>

    <?= $form->field($model, 'chartering_id') ?>

    <?= $form->field($model, 'invoice_number') ?>

    <?= $form->field($model, 'vessel_id') ?>

    <?= $form->field($model, 'fixture_ref') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'cp_date') ?>

    <?php // echo $form->field($model, 'freight') ?>

    <?php // echo $form->field($model, 'commission_percentage') ?>

    <?php // echo $form->field($model, 'VAT') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'start_period') ?>

    <?php // echo $form->field($model, 'end_period') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

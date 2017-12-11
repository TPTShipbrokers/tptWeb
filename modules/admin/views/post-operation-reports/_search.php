<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OperationReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-operation-report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'report_id') ?>

    <?= $form->field($model, 'mooring_master') ?>

    <?= $form->field($model, 'supply_vessel') ?>

    <?= $form->field($model, 'fenders_supplied') ?>

    <?= $form->field($model, 'hoses_supplied') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'cargo_parcel') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

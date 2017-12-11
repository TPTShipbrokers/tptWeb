<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClaimsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claims-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'claim_id') ?>

    <?= $form->field($model, 'owners_claim') ?>

    <?= $form->field($model, 'owners_claim_reason') ?>

    <?= $form->field($model, 'charterers_claim') ?>

    <?= $form->field($model, 'charterers_claim_reason') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'chartering_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

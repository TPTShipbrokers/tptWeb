<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CharteringSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chartering-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'chartering_id') ?>

    <?= $form->field($model, 'vessel_id') ?>

    <?= $form->field($model, 'subs_due') ?>

    <?= $form->field($model, 'ship_documentation') ?>

    <?= $form->field($model, 'stowage_plan') ?>

    <?php // echo $form->field($model, 'charter_party') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

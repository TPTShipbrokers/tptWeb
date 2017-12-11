<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VesselSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vessel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'vessel_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'size') ?>

    <?= $form->field($model, 'built') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'open_date') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'cbm') ?>

    <?php // echo $form->field($model, 'dwt') ?>

    <?php // echo $form->field($model, 'loa') ?>

    <?php // echo $form->field($model, 'last') ?>

    <?php // echo $form->field($model, 'imo') ?>

    <?php // echo $form->field($model, 'hull') ?>

    <?php // echo $form->field($model, 'sire') ?>

    <?php // echo $form->field($model, 'intake') ?>

    <?php // echo $form->field($model, 'tema_suitable') ?>

    <?php // echo $form->field($model, 'cabotage') ?>

    <?php // echo $form->field($model, 'nigerian_cab') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'last_update') ?>

    <?php // echo $form->field($model, 'broker_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WeatherReport */
/* @var $form ActiveForm */
?>
<div class="weather_report_form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'location_id') ?>
        <?= $form->field($model, 'datetime') ?>
        <?= $form->field($model, 'surf_max') ?>
        <?= $form->field($model, 'period') ?>
        <?= $form->field($model, 'wind_min') ?>
        <?= $form->field($model, 'wind_max') ?>
        <?= $form->field($model, 'wind_dir') ?>
        <?= $form->field($model, 'wind_deg') ?>
        <?= $form->field($model, 'surf_min') ?>
        <?= $form->field($model, 'surf_dir') ?>
        <?= $form->field($model, 'surf_deg') ?>
        <?= $form->field($model, 'seas') ?>
        <?= $form->field($model, 'comment') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- weather_report_form -->

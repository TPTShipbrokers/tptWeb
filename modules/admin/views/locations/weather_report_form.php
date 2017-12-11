<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WeatherReport */
/* @var $form ActiveForm */
?>
<div class="weather_report_form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ['id' => 'report-form', 'data-action' => 'manual']

    ]); ?>

    <div class="form-group">
        <label class="control-label">Date / Time</label>
        <div>
            <div class="form_datetime_event" data-format="yyyy-MM-dd hh:mm"
                 data-date="<?= date('Y-m-d 12:00') ?>"></div>
        </div>
    </div>
    <input type="hidden" name="WeatherReport[weather_report_id]" value="<?= $model->weather_report_id ?>"/>
    <?= $form->field($model, 'surf_min',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '1']
        ])
        ->input(['required' => false])
        ->label('SURF MIN') ?>
    <?= $form->field($model, 'surf_max',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '1']
        ])
        ->input(['required' => false])
        ->label('SURF MAX') ?>

    <?= $form->field($model, 'surf_dir',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control']
        ])
        ->input(['required' => false])
        ->label('SURF DIR')
        ->hint('Ex. S, SSW, SE ...') ?>
    <?= $form->field($model, 'seas',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '0.1']
        ])
        ->input(['required' => false])
        ->label('SEAS') ?>
    <?= $form->field($model, 'period',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '0.1']
        ])
        ->input(['required' => false])
        ->label('PERIOD') ?>

    <?= $form->field($model, 'wind_min',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '1']
        ])
        ->input(['required' => false])
        ->label('WIND MIN') ?>
    <?= $form->field($model, 'wind_max',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '1']
        ])
        ->input(['required' => false])
        ->label('WIND MAX') ?>

    <?= $form->field($model, 'wind_dir',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control']
        ])
        ->input(['required' => false])
        ->label('WIND DIR')
        ->hint('Ex. S, SSW, SE ...') ?>
    <?= $form->field($model, 'wind_deg',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'step' => '1']
        ])
        ->input(['required' => false])
        ->label('WIND DEG') ?>

    <?= $form->field($model, 'comment',
        [
            'options' => ['class' => 'form-group form-md-line-input'],
            'template' => '{input}{hint}{error}{label}',
            'inputOptions' => ['class' => 'form-control']
        ])
        ->textArea(['required' => false, 'maxlength' => 300, 'rows' => 3, 'cols' => 10])
        ->label('Comment') ?>

    <div class="form-group">
        <button type="button" class="btn btn-danger" onClick="addWeatherReport('#report-form')">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- weather_report_form -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vessel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vessel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->dropDownList([ 'mr' => 'Mr', 'handy' => 'Handy', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'built')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'open' => 'Open', 'on_subs' => 'On subs', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'open_date')->textInput() ?>

    <?= $form->field($model, 'location')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cbm')->textInput() ?>

    <?= $form->field($model, 'dwt')->textInput() ?>

    <?= $form->field($model, 'loa')->textInput() ?>

    <?= $form->field($model, 'last')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imo')->textInput() ?>

    <?= $form->field($model, 'hull')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sire')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'intake')->textInput() ?>

    <?= $form->field($model, 'tema_suitable')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', 'tbt' => 'Tbt', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'nigerian_cab')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'last_update')->textInput() ?>

    <?= $form->field($model, 'broker_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

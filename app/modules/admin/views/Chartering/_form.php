<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Chartering */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chartering-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vessel_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subs_due')->textInput() ?>

    <?= $form->field($model, 'ship_documentation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'stowage_plan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'charter_party')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

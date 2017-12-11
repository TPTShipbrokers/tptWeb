<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Claims */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claims-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'owners_claim')->textInput() ?>

    <?= $form->field($model, 'owners_claim_reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'charterers_claim')->textInput() ?>

    <?= $form->field($model, 'charterers_claim_reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'chartering_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

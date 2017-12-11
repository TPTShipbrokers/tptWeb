<?php

use app\models\AraPosition;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AraPosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vessel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->dropDownList([
        AraPosition::SIZE_MR => 'Mr',
        AraPosition::SIZE_HANDY => 'Handy',
        AraPosition::SIZE_LR => 'LR'
    ], ['prompt' => '']) ?>

    <?= $form->field($model, 'grade')->dropDownList([
        AraPosition::CONDITION_CLEAN => 'Clean',
        AraPosition::CONDITION_DIRTY => 'Dirty'
    ], ['prompt' => '']) ?>

    <?= $form->field($model, 'built')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'status')->dropDownList(['open' => 'Open', 'on_subs' => 'On subs',], ['prompt' => '']) ?>

    <?= $form->field($model, 'open_date')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->open_date))]) ?>

    <?= $form->field($model, 'location')->textInput() ?>

    <?= $form->field($model, 'sire')->dropDownList(['yes' => 'Yes', 'no' => 'No',], ['prompt' => '']) ?>


    <?= $form->field($model, 'tema_suitable')->textInput() ?>

    <?= $form->field($model, 'cbm')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'dwt')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'loa')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'last')->textInput() ?>

    <?= $form->field($model, 'imo')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'hull')->textInput() ?>


    <?= $form->field($model, 'intake')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'nigerian_cab')->textInput() ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'last_update')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->last_update))]) ?>
    <?= $form->field($model, 'positions_visible')->checkbox([
        'label' => '',
        'labelOptions' => ['style' => 'padding:5px;'],
        'class' => 'make-switch', 'data' => ['on' => 'success', 'on-color' => 'success', 'off-color' => 'default', 'size' => 'big', 'id' => 'visibleSettings']])
        ->label('Visible on positions list?');
    ?>
    <?= $this->render('assign-form',
        [
            'label' => 'Broker',
            'id' => 'assignBrokerForm',
            'title' => 'Assign broker for tanker ',
            'modal_id' => '#newBrokerModal',
            'all' => $all_team,
            'value' => 'user_id',
            'text' => 'full_name',
            'name' => 'broker_id',
            'selected' => $broker,
            'multiple' => false
        ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>

    $(document).ready(function () {

        Main.initDatetimePicker(".form_datetime_status");

    });
</script>

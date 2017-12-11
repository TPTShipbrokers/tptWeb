<?php

use app\models\Status;
use app\models\Vessel;
use yii\helpers\ArrayHelper;
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

    <?= $form->field($model, 'subs_due') ?>

    <?php // echo $form->field($model, 'charter_party') ?>

    <?php $statuses = ArrayHelper::map(Status::find()->asArray()->all(), 'status_id', 'description'); ?>
    <?= $form->field($model, 'status_id')->dropDownList($statuses, ['prompt' => '-Choose a Status-']); ?>

    <?= $form->field($model, 'state')->dropDownList([
        'all' => 'All',
        'completed' => 'Past',
        'live' => 'Live'
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

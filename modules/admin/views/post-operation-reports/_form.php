<?php

use app\models\AppUser;
use app\models\Operation;
use app\models\Ship;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostOperationReport */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">

        <?php foreach ($errors as $error): ?>
        <b> <?= $error ?>

            <?php endforeach; ?>
    </div>

<?php endif; ?>
<div class="post-operation-report-form">


    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ["enctype" => "multipart/form-data", 'class' => '', 'id' => 'newNewsletterForm']

    ]); ?>

    <div class="well">

        <label> Operation </label>


        <?php

        if (!$model->operation) {
            echo '<div class="alert alert-danger">Operation not assigned</div>';
        }

        $operations = Operation::find()->all();

        $listData[] = '';
        foreach ($operations as $a) {
            $listData[$a->operation_id] = $a->reference_id . ': ' . $a->dischargingShip->name . ' ' . $a->receivingShip->name;
        }

        $options = ['class' => 'form-control'];

        if ($model->operation) {

            $options['options'] = [
                $model->operation->operation_id => ['selected ' => true],
            ];
        }

        echo Html::dropDownList('PostOperationReport[operation_id]', null, $listData, $options);
        ?>

    </div>


    <?php

    $users = AppUser::find()->where(['role' => 'team'])->all();

    $listData = [];
    $listData[] = '';

    foreach ($users as $a) {
        $listData[$a->user_id] = $a->first_name . ' ' . $a->last_name;
    }

    echo $form->field($model, 'mooring_master')
        ->dropDownList(
            $listData,           // Flat array ('id'=>'label')
            [
                'options' =>
                    [
                        $model->mooring_master => ['selected ' => true]
                    ]
            ]
        ); ?>

    <?php

    $ships = Ship::find()->all();

    $listData = [];
    $listData[] = '';

    foreach ($ships as $a) {
        $listData[$a->ship_id] = $a->name;
    }

    echo $form->field($model, 'supply_vessel')
        ->dropDownList(
            $listData,           // Flat array ('id'=>'label')
            ['options' =>
                [
                    $model->supply_vessel => ['selected ' => true]
                ]
            ]    // options
        ); ?>


    <?= $form->field($model, 'fenders_supplied')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'hoses_supplied')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cargo_parcel')->textarea(['rows' => 6]) ?>


    <div class="form-group">

        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail">
                <?php if (!$model->file): ?>
                    <span class="label label-danger">No file</span>
                <?php else: ?>
                <embed src="<?= Url::home(true) ?>/<?= $model->file ?>" type='application/pdf'>
                    <?php endif; ?>
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"
                 style="max-width: 200px; max-height: 150px;"></div>


            <span class="btn default btn-file">
            <span class="fileinput-new"> Select file </span>
            <span class="fileinput-exists"> Change </span>
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
         </span>
            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

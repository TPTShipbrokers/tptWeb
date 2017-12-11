<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostOperationReport */

$this->title = 'Update Post Operation Report: ' . ' ' . $model->report_id;
$this->params['breadcrumbs'][] = ['label' => 'Post Operation Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->report_id, 'url' => ['view', 'id' => $model->report_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-operation-report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

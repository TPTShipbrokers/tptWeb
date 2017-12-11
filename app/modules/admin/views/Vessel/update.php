<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vessel */

$this->title = 'Update Vessel: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vessels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->vessel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vessel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

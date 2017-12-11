<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chartering */

$this->title = 'Update Chartering: ' . ' ' . $model->chartering_id;
$this->params['breadcrumbs'][] = ['label' => 'Chartering', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chartering_id, 'url' => ['view', 'id' => $model->chartering_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chartering-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

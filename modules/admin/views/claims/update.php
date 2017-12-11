<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Claims */

$this->title = 'Update Claims: ' . ' ' . $model->claim_id;
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->claim_id, 'url' => ['view', 'id' => $model->claim_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="claims-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

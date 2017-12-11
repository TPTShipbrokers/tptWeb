<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vessel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vessels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vessel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->vessel_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->vessel_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'vessel_id',
            'name',
            'size',
            'built',
            'status',
            'open_date',
            'location:ntext',
            'cbm',
            'dwt',
            'loa',
            'last:ntext',
            'imo',
            'hull:ntext',
            'sire',
            'intake',
            'tema_suitable',
            'cabotage:ntext',
            'nigerian_cab:ntext',
            'comments:ntext',
            'last_update',
            'broker_id',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Chartering */

$this->title = $model->chartering_id;
$this->params['breadcrumbs'][] = ['label' => 'Chartering', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chartering-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->chartering_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->chartering_id], [
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
            'chartering_id',
            'vessel_id',
            'subs_due',
            'ship_documentation:ntext',
            'stowage_plan:ntext',
            'charter_party',
            'status_id',
        ],
    ]) ?>

</div>

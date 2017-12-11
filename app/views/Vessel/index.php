<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VesselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vessels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vessel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vessel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'vessel_id',
            'name',
            'size',
            'built',
            'status',
            // 'open_date',
            // 'location:ntext',
            // 'cbm',
            // 'dwt',
            // 'loa',
            // 'last:ntext',
            // 'imo',
            // 'hull:ntext',
            // 'sire',
            // 'intake',
            // 'tema_suitable',
            // 'cabotage:ntext',
            // 'nigerian_cab:ntext',
            // 'comments:ntext',
            // 'last_update',
            // 'broker_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

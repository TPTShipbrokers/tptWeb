<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CharteringSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chartering';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chartering-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Chartering', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'chartering_id',
            'vessel_id',
            'subs_due',
            'ship_documentation:ntext',
            'stowage_plan:ntext',
            // 'charter_party',
            // 'status_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

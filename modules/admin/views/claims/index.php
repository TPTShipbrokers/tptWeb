<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClaimsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Claims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claims-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Claims', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'claim_id',
            'owners_claim',
            'owners_claim_reason:ntext',
            'charterers_claim',
            'charterers_claim_reason:ntext',
            // 'comments:ntext',
            // 'status:ntext',
            // 'chartering_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'invoice_id',
            'chartering_id',
            'invoice_number',
            'vessel_id',
            'fixture_ref',
            // 'reference',
            // 'cp_date',
            // 'freight:ntext',
            // 'commission_percentage',
            // 'VAT',
            // 'total',
            // 'status',
            // 'due_date',
            // 'start_period',
            // 'end_period',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

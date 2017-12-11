<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoicesSearch */
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
    <?php if ($dataProvider->getCount() > 0): ?>
        <?= $this->render('_table', ['dataProvider' => $dataProvider]); ?>
    <?php else: ?>
        <div class="well">No invoices available.</div>
    <?php endif; ?>

</div>

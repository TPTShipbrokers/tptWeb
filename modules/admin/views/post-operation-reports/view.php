<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostOperationReport */

/*$this->title = $model->report_id;
$this->params['breadcrumbs'][] = ['label' => 'Post Operation Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="post-operation-report-view">

    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Report Details
        <small>post operation report</small>
    </h3>
    <!-- END PAGE TITLE-->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->report_id], ['class' => 'btn btn-info btn-lg hide-print']) ?>
        <a class="btn btn-lg green-haze hidden-print uppercase print-btn" onclick="javascript:window.print();">Print</a>
        <?php if ($model->file): ?>
            <a class="btn btn-lg blue-salsa btn-outline  hide-print"
               href="<?= Yii::$app->request->baseUrl . '/' . $model->file ?>" target="_blank">View Report Document</a>
        <?php else: ?>
            <span class="label label-danger"> PDF not ready </span>
        <?php endif; ?>
        <span class="pull-right">      
            <?= Html::a('Delete', ['delete', 'id' => $model->report_id], [
                'class' => 'btn btn-danger btn-lg  hide-print',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </span>
    </p>


    <div class="invoice-content-2 bordered">
        <div class="row invoice-head">
            <div class="col-md-7 col-xs-6">
                <div class="invoice-logo">
                    <img src="<?= Yii::$app->request->baseUrl . '/assets/pages/media/invoice/report_logo.png' ?>"
                         class="img-responsive" alt=""/>
                    <img src="<?= Yii::$app->request->baseUrl . '/assets/pages/media/invoice/invoice_logo.png' ?>"
                         class="img-responsive" alt=""/>
                    <h1 class="uppercase text-center" style="margin-top: 100px">Post Operation Report</h1>

                </div>
            </div>

            <div class="col-md-5 col-xs-6">
                <div class="company-address">
                    <span class="bold uppercase">Top Fenders Limited</span>
                    <br/> 5 Welbeck Street, Ground Floor
                    <br/> London, W1G 9YQ, United Kingdom
                    <br/>
                    <span class="bold"><abbr title="Phone">T:</span> +44(0) 203 219 5780
                    <br/>
                    <span class="bold"><abbr title="Fax">F:</span> +44(0) 203 219 5788
                    <br/>
                    <span class="bold"><abbr title="Fax">E:</abbr></span> <a href="mailto:sts@topfenders.com">
                        sts@topfenders.com </a>
                </div>
            </div>
        </div>
        <div class="row invoice-cust-add">
            <?php if ($operation): ?>
                <div class="col-md-3">
                    <h2 class="invoice-title uppercase">Client</h2>
                    <p class="invoice-desc"><?= $operation->user->first_name . ' ' . $operation->user->last_name ?></p>
                </div>

                <div class="col-md-3">
                    <h2 class="invoice-title uppercase">Date</h2>
                    <p class="invoice-desc"><?= date('d M, Y', strtotime($operation->start_time)) . '-' . date('d M, Y', strtotime($operation->end_time)) ?></p>
                </div>
                <div class="col-md-6">
                    <h2 class="invoice-title uppercase">Operation</h2>
                    <p class="invoice-desc invoice-desc">

                        #<?= $operation->reference_id ?><br><br>
                        <?= $operation->dischargingShip->name . '-' . $operation->receivingShip->name ?></p>

                </div>
            <?php else: ?>
                <div class="alert alert-danger"> Operation not assigned</div>
            <?php endif; ?>
        </div>
        <div class="row invoice-body">
            <div class="col-xs-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="invoice-title uppercase"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <h3>Mooring Master</h3>
                            <p><?= $model->mooringMaster->first_name . ' ' . $model->mooringMaster->last_name ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Supply Vessel</h3>
                            <p><?= $model->supplyVessel->name ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Fenders Supplied</h3>
                            <p><?= $model->fenders_supplied ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Hoses Supplied</h3>
                            <p><?= $model->hoses_supplied ?> </p>
                        </td>
                    </tr>
                    <?php if ($operation): ?>
                        <tr>
                            <td>
                                <h3>Location</h3>
                                <p><?= $operation->location->title ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>Date</h3>
                                <p><?= date('d M, Y', strtotime($operation->start_time)) . '-' . date('d M, Y', strtotime($operation->end_time)) ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>Discharging Vessel</h3>
                                <p><?= $operation->dischargingShip->name ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>Receiving Vessel</h3>
                                <p><?= $operation->receivingShip->name ?> </p>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td>
                            <h3>Cargo Parcel</h3>
                            <p><?= $model->cargo_parcel ?> </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

            </div>
        </div>
    </div>

</div>

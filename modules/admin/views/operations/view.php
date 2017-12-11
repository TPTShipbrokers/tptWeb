<?php
use yii\helpers\Url;

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Operation Details
    <small> & statement of facts</small>
</h3>
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <div class="caption">

            <i class="fa fa-cogs"></i>
            <span class="caption-subject font-red-sharp bold uppercase">Operation details</span>

        </div>
        <div class="hide-print pull-right">
            <a href="<?= Url::toRoute('operations/update/' . $model->operation_id) ?>" target="_blank"
               class=" btn green btn-sm"><i class="fa fa-edit"></i>Update</a>
            <a href="javascript:;" onclick="javascript:window.print();" class=" btn blue btn-sm"><i
                        class="fa fa-print"></i>Print</a>
        </div>


    </div>
    <div class="portlet-body">

        <div class="well">
            <div class="row">
                <div class="col-md-4">TopFenders ref.:</div>
                <div class="col-md-8"><?= $model->reference_id ?></div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">Discharging vessel:</div>
                <div class="col-md-8"><?= $model->dischargingShip->name ?></div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">Receiving vessel:</div>
                <div class="col-md-8"><?= $model->receivingShip->name ?></div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">Location:</div>
                <div class="col-md-8"><?= $model->location->title ?></div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">Status:</div>
                <div class="col-md-8">
                   
                    <span class="label <?= $model->end_time != null ? 'label-success' : 'label-info' ?>"> 
                      
                        <?= $model->end_time != null ? ' <i class="fa fa-check"></i>' : '' ?>


                        <?= $model->operationState->state->description ?> 
                    </span>
                    <br>
                    <br>
                    <span class="date"><?= date('d M, Y H:i', strtotime($model->operationState->time)) ?></span>


                </div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">Post operation report:</div>
                <div class="col-md-8">

                    <?php if ($model->report_id): ?>
                        <div class="update-pane">

                            <div class="form-group">

                                <a class="btn btn-sm grey-salsa btn-outline"
                                   href="<?= Yii::$app->request->baseUrl . '/' . $model->report->file ?>"
                                   target="_blank">View Report Document</a>

                                <a class="btn btn-sm red-sunglo btn-outline"
                                   href="<?= Url::toRoute('post-operation-reports/view/' . $model->report_id) ?>"
                                   target="_blank">View Report Details</a></td>

                            </div>
                        </div>

                    <?php else: ?>
                        <span class="label label-danger">not ready</span>
                    <?php endif; ?>

                </div>
                <div class="clearfix"></div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">Invoice:</div>
                <div class="col-md-8">

                    <?php if ($model->invoice_id): ?>
                        <div class="update-pane">

                            <div class="form-group">

                                <a class="btn btn-sm grey-salsa btn-outline"
                                   href="<?= Yii::$app->request->baseUrl . '/' . $model->invoice->file ?>"
                                   target="_blank"> View Invoice Document </a>

                                <a class="btn btn-sm red-sunglo btn-outline"
                                   href="<?= Url::toRoute('invoices/view/' . $model->invoice_id) ?>" target="_blank">
                                    View Invoice Details
                                </a>

                            </div>
                        </div>
                    <?php else: ?>
                        <span class="label label-danger">not ready</span>
                    <?php endif; ?>

                </div>
                <div class="clearfix"></div>
            </div>
            <hr>
        </div>

        <hr>

        <h3 class="page-title"> Latest update
            <small> operation states</small>
        </h3>

        <ul class="feeds op_stat">
            <?php foreach ($model->getOperationStates()->orderby('time desc')->all() as $op_state): ?>
                <li id="state<?= $op_state->operation_state_id ?>">

                    <div class="row">
                        <div class="col-md-1 hide-print">
                            <div class="label label-sm label-<?= $op_state->state_id == $model->status_id ? "danger" : "success" ?>">

                                <i class="fa fa-<?= $op_state->state_id == $model->status_id ? "check" : "bell-o" ?>"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="desc">
                                <?php
                                $prefix = $op_state->desc_prefix_sufix != null && $op_state->desc_prefix_sufix == 1;
                                $desc = $prefix ? $op_state->description . ' ' . $op_state->state->description : $op_state->state->description . ' ' . $op_state->description;

                                ?>
                                <?= $desc ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="date"> <?= date('d M, Y H:i', strtotime($op_state->time)) ?> </div>
                        </div>

                    </div>

                </li>
            <?php endforeach; ?>

        </ul>
    </div>


    <!--END TABS-->
</div>
</div>
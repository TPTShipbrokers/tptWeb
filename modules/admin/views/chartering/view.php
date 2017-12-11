<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Chartering */

$this->title = $model->chartering_id;
$this->params['breadcrumbs'][] = ['label' => 'Chartering', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chartering-view">


    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Chartering Details
        <small> & statement of facts</small>
    </h3>
    <div class="portlet-title tabbable-line mt-element-ribbon">

        <div class="caption pull-left">

            <i class="fa fa-cogs"></i>
            <span class="caption-subject font-red-sharp bold uppercase"><?= $model->vessel_name ?></span>
            <span class="label label-danger"><?= $completed ? "Completed" : "In Progress" ?></span>

        </div>
        <div class="hide-print pull-right">
            <?= Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->chartering_id], ['class' => 'btn green btn-sm']) ?>
            <a href="javascript:;" onclick="javascript:window.print();" class=" btn blue btn-sm"><i
                        class="fa fa-print"></i>Print</a>
        </div>
        <div class="clearfix"></div>


    </div>
    <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> Overview </a>
            </li>
            <li>
                <a href="#tab_1_2" data-toggle="tab"> Clients & Companies </a>
            </li>
            <li>
                <a href="#tab_1_3" data-toggle="tab"> Statuses </a>
            </li>
            <!--li>
               <a href="#tab_1_4" data-toggle="tab"> Invoices </a>
           </li-->
            <li>
                <a href="#tab_1_5" data-toggle="tab"> Charter Party </a>
            </li>
            <li>
                <a href="#tab_1_6" data-toggle="tab"> Claims </a>
            </li>

        </ul>
        <div class="tab-content">

            <div class="tab-pane active" id="tab_1_1">
                <div class="well">
                    <div class="row">
                        <div class="col-md-4">#ID:</div>
                        <div class="col-md-8"><?= $model->chartering_id ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">Tanker:</div>
                        <div class="col-md-8">
                            <?= empty($model->vessel) ? $model->vessel_name : $model->vessel->name ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">Subs due:</div>
                        <div class="col-md-8"><?= date('d M, Y H:i', strtotime($model->subs_due)) ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">Status:</div>
                        <div class="col-md-8">
                            <?php if ($model->status): ?>
                                <span class="label label-info"> 
                              
                              
                                <i class="fa fa-check"></i>
                                    <?= $model->status->status->description ?> 

                            </span>
                                <br>
                                <br>
                                <span class="date"><?= date('d M, Y H:i', strtotime($model->status->datetime)) ?></span>

                            <?php else: ?>
                                <span class="label label-warning"> Status not set </span>
                            <?php endif; ?>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">Chartering state:</div>
                        <div class="col-md-8">
                            <?php if ($model->state):
                                $states = [
                                    'subs_due' => 'Subs Countdown',
                                    'subs_failed' => 'Subs failed',
                                    'live' => 'Fixture agreed - live',
                                    'completed' => 'Completed - chartering marked as past'
                                ];
                                ?>
                                <span class="label label-success"> 
                              
                              
                                <i class="fa fa-check"></i>
                                    <?= $states[$model->state] ?> 

                            </span>

                            <?php else: ?>
                                <span class="label label-warning"> No status set </span>
                            <?php endif; ?>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">Ship documentation:</div>
                        <div class="col-md-8">

                            <?php if (!empty($model->shipDocumentations)): ?>

                                <div class="update-pane">

                                    <div class="form-group">
                                        <?php foreach ($model->shipDocumentations as $doc): ?>
                                            <a class="btn btn-sm grey-salsa btn-outline"
                                               href="<?= Yii::$app->request->baseUrl . '/' . $doc->file ?>"
                                               target="_blank"><?= $doc->filename ? $doc->filename : "View Document" ?></a>
                                        <?php endforeach; ?>
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
                        <div class="col-md-4">Invoices:</div>
                        <div class="col-md-8">

                            <?php if (!empty($model->invoiceDocumentations)): ?>

                                <div class="update-pane">
                                    <div class="form-group">
                                        <?php foreach ($model->invoiceDocumentations as $doc): ?>
                                            <a class="btn btn-sm grey-salsa btn-outline"
                                               href="<?= Yii::$app->request->baseUrl . '/' . $doc->file ?>"
                                               target="_blank"><?= $doc->filename ? $doc->filename : "View Document" ?></a>
                                        <?php endforeach; ?>
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
                        <div class="col-md-4">Broker:</div>
                        <div class="col-md-8">

                            <?php if ($model->broker_id): ?>
                                <div class="update-pane">

                                    <div class="form-group">

                                        <?php $broker = $model->getBroker()->one(); ?>

                                        <a class="btn btn-sm grey-salsa btn-outline"
                                           href="<?= Url::toRoute('users/view/' . $broker->user_id) ?>"
                                           target="_blank"><?= $broker->first_name . " " . $broker->last_name ?></a>

                                    </div>
                                </div>

                            <?php else: ?>
                                <span class="label label-danger">not assigned</span>
                            <?php endif; ?>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane " id="tab_1_2">
                <div class="assigned">
                    <h3 class="page-title"> Clients
                        <small> assigned clients</small>
                    </h3>
                    <div class="well">
                        <?php $clients = $model->getCharteringClients()->all();

                        if (empty($clients)): ?>
                            <p> There are no clients assigned to this chartering </p>
                        <?php endif;

                        foreach ($clients as $client): ?>
                            <div id="client_row<?= $client->client_id ?>">
                                <p>
                                    <a href="#assigned_client_<?= $client->client_id ?>" data-toggle="collapse"
                                       target="_blank" class="btn green  btn-outline accordion-toggle collapsed"
                                       aria-expanded="false">
                                        <?= $client->client->first_name . ' ' . $client->client->last_name ?> <i
                                                class="fa fa-angle-down"></i>
                                    </a>
                                </p>
                                <p id="assigned_client_<?= $client->client_id ?>" class="panel-collapse collapse"
                                   aria-expanded="false">
                                    <a href="javascript:;" class="confirmation-assign btn" data-idprefix="#client_row"
                                       data-id="<?= $client->client_id ?>"
                                       data-url="<?= Url::toRoute('chartering/remove_client/' . $client->client_id) ?>"
                                       data-message="Client successfully removed from chartering."
                                       data-errormessage="An error occured while trying to reassign client."><i
                                                class="fa fa-close"></i> Remove user from chartering </a>
                                    <a class="btn btn-success"
                                       href="<?= Url::toRoute('users/view/' . $client->client_id) ?>" target="_blank">
                                        View client details </a>
                                </p>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div class="assigned">
                    <h3 class="page-title"> Companies
                        <small> assigned companies</small>
                    </h3>
                    <div class="well">
                        <?php
                        $companies = $model->getCharteringCompanies()->all();

                        if (empty($companies)): ?>

                            <p> There are no companies assigned to this chartering </p>

                        <?php endif;

                        foreach ($companies as $company): ?>
                            <div id="company_row<?= $company->company_id ?>">
                                <p>
                                    <a href="#assigned_company_<?= $company->company_id ?>" data-toggle="collapse"
                                       target="_blank" class="btn  grey-salsa  btn-outline accordion-toggle collapsed">
                                        <?= $company->company->company_name ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                </p>
                                <p id="assigned_company_<?= $company->company_id ?>" class="panel-collapse collapse"
                                   aria-expanded="false" aria-expanded="false">
                                    <a href="javascript:;" class="confirmation-assign btn" data-idprefix="#company_row"
                                       data-id="<?= $company->company_id ?>"
                                       data-url="<?= Url::toRoute('chartering/remove_company/' . $company->company_id) ?>"
                                       data-message="Company successfully removed from chartering."
                                       data-errormessage="An error occured while trying to reassign company."><i
                                                class="fa fa-close"></i> Remove company from chartering </a>
                                </p>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
            <div class="tab-pane " id="tab_1_5">

                <div class="assigned">
                    <h3 class="page-title"> Charter Party
                        <small> assigned charter party</small>
                    </h3>
                    <div>
                        <?php
                        $party = $model->getCharterParty()->one();

                        if (!$party): ?>

                            <p> There is no charter party assigned to this chartering </p>

                        <?php else: ?>


                            <div class="well">

                                <span class="date btn btn-outline red"> <?= date('d M, Y H:i', strtotime($party->datetime)) ?></span>
                                <br>
                                <br>

                                <p> <?= nl2br($party->description) ?> </p>

                            </div>


                        <?php endif; ?>


                    </div>
                </div>

            </div>
            <div class="tab-pane " id="tab_1_4">

                <?php if ($invoices->getCount() > 0): ?>
                    <?= $this->render('/invoices/_table', ['dataProvider' => $invoices]) ?>
                <?php else: ?>
                    <div class="well">There are no invoices for this chartering</div>
                <?php endif; ?>

            </div>
            <div class="tab-pane " id="tab_1_3">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">


                            <h3 class="page-title">
                                <i class="icon-flag font-green-sharp"></i> Latest update
                                <small> chartering states</small>
                            </h3>


                        </div>
                        <div class="hide-print pull-right">
                            <a data-toggle="modal" data-target="#newStatusModal" class=" btn red btn-sm"><i
                                        class="fa fa-plus"></i> Change status</a>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <!--BEGIN TABS-->
                        <div class="tab-content">

                            <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                <?= $this->render('/statuses/list', ['statuses' => $model->getCharteringStatuses()->orderby('datetime desc')->all(), 'delete' => true, 'update' => false, 'status_id' => $model->status_id, 'chartering_id' => $model->chartering_id]); ?>

                            </div>
                            <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                <h3>SOF Comments</h3>
                                <?= nl2br($model->sof_comments) ?> </span>
                            </div>

                        </div>
                        <!--END TABS-->
                    </div>
                </div>
            </div>

            <div class="tab-pane " id="tab_1_6">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">

                            <i class="icon-flag font-green-sharp"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Claims</span>


                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">

                        <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1"
                             id="claims-container">
                            <?php if (empty($model->claims)): ?>
                                <div class="well empty">There are no claims for this chartering.</div>

                            <?php else: ?>
                            <?php foreach ($model->claims as $claim): ?>


                                <?= $this->render('/claims/view', ['model' => $claim, 'actions' => false]); ?>

                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>


                    </div>


                </div>

            </div>


        </div>
    </div>

</div>

</div>
<?= $this->render('/modal-template', ['id' => 'newStatusModal', 'title' => 'Change status', 'subtitle' => 'set chartering status', 'content_template' => 'statuses/status_form', 'content_data' => ['chartering_id' => $model->chartering_id, 'date' => null, 'status' => null, 'update' => false]]); ?>


<script>

    $(document).ready(function () {

        Main.init();
        Main.initConfirmation('.confirmation-assign', false, {'chartering_id': <?=$model->chartering_id?>});
        Main.initConfirmation('.confirmation-delete', false, {
            "chartering_id": <?=$model->chartering_id?>,
            "action": "delete"
        });
        toastr.options.closeDuration = 50;
        Main.initDatetimePicker(".form_datetime_status");

        $('#status_form_wrap_new .set-btn').click(function () {
            Main.save('#status_form_new', null, function () {
                toastr.success('Chartering status successfully set.');
                setTimeout(function () {
                    location.reload();
                }, 3000);
            });
        });

        var statuses = [
            <?php foreach($all_statuses as $status): ?>
            {num: "<?=$status->description?>", id: <?=$status->status_id?>  },
            <?php endforeach; ?>
        ];

        Main.initTypeahead('#typeahead_status', statuses, '#typeahead_status_id');


    });


</script>



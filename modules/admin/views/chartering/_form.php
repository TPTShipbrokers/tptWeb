<?php

use app\models\CharterParty;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var array $vessels
 * @var $this yii\web\View
 * @var $model app\models\Chartering
 * @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ["enctype" => "multipart/form-data"]]); ?>


<div class="tab-content <?php if (!$model->isNewRecord): ?>col-md-6<?php else: ?> col-md-12 <?php endif; ?>">

    <div class="form-actions">
        <br>
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => 'btn btn-success btn-lg']) ?>

        <?php if ($model->isNewRecord): ?>
        <a href="<?= Url::toRoute('index') ?>"
           class="btn btn-default  btn-lg">Cancel</a>

        <?php else: ?>
            <a href="<?= Url::toRoute('chartering/view/' . $model->chartering_id) ?>"
               class="btn btn-default  btn-lg">Cancel</a>
            <a href="<?= Url::toRoute('chartering/view/' . $model->chartering_id) ?>" class="btn btn-danger "
               style="margin-left: 15px">View Chartering Details</a>
        <?php endif; ?>

    </div>

    <div class="chartering-form">

        <?php if ($model->isNewRecord): ?>
        <div class="row">
            <div class="col-md-6"> <?php endif; ?>
                <h3 class="page-title"> Chartering Details </h3>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Vessel
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-ship"></i>
                        </span>
                            <input type="hidden" id="vessel_name" name="vessel_name" class="form-control"
                                   value="<?= $model->vessel_name ?>"/>
                            <input type="text" id="typeahead_vessel" name="vessel" class="form-control"
                                   value="<?= !empty($model->vessel) ? $model->vessel->name : $model->vessel_name ?>"/>
                        </div>
                        <p class="help-block"> Start typing tanker name to choose an existing tanker E.g: MT Alpine
                            X </p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"> Subs due
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </span>
                            <?= $form->field($model, 'subs_due')->textInput(['class' => 'form_datetime_status form-control', 'value' => $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($model->subs_due))])->label(false) ?>
                        </div>
                        <p class="help-block"> Click to open calendar </p>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Ship documentation </label>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 400px; ">
                            <?php if (!empty($model->shipDocumentations)): ?>

                                <div class="update-pane">

                                    <div class="form-group">
                                        <?php foreach ($model->shipDocumentations as $doc): ?>
                                            <div id="ship_doc_row<?= $doc->ship_documentation_id ?>">
                                                <a class="btn btn-sm grey-salsa btn-outline"
                                                   href="#ship_doc_<?= $doc->ship_documentation_id ?>"
                                                   data-toggle="collapse"
                                                   target="_blank"
                                                   class="btn green  btn-outline accordion-toggle collapsed"
                                                   aria-expanded="false">
                                                    <?= $doc->filename ? $doc->filename : "View Document" ?>
                                                </a>
                                                <p id="ship_doc_<?= $doc->ship_documentation_id ?>"
                                                   class="panel-collapse collapse"
                                                   aria-expanded="false">
                                                    <a href="javascript:;"
                                                       class="confirmation-ship-doc btn"
                                                       data-idprefix="#ship_doc_row"
                                                       data-id="<?= $doc->ship_documentation_id ?>"
                                                       data-url="<?= Url::toRoute('chartering/remove_ship_documentation/' . $doc->ship_documentation_id) ?>"
                                                       data-message="Document successfully removed from chartering."
                                                       data-errormessage="An error occured while trying to remove document.">
                                                        <i class="fa fa-close"></i> Remove document </a>
                                                    <a class="btn btn-success"
                                                       href="<?= Yii::$app->request->baseUrl . '/' . $doc->file ?>"
                                                       target="_blank"> View document
                                                    </a>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="label label-danger">not ready</span>
                            <?php endif; ?>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"
                             style="max-width: 200px; max-height: 150px;"></div>

                        <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <?= $form->field($model, 'ship_documentations[]')->fileInput(['multiple' => true])->label(false) ?> </span>
                            <a href="javascript:;" class="btn default fileinput-exists"
                               data-dismiss="fileinput">Remove </a>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Invoices </label>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 400px; ">
                            <?php if (!empty($model->invoiceDocumentations)): ?>
                                <div class="update-pane">
                                    <div class="form-group">
                                        <?php foreach ($model->invoiceDocumentations as $doc): ?>
                                            <div id="invoice_doc_row<?= $doc->invoice_documentation_id ?>">
                                                <a class="btn btn-sm grey-salsa btn-outline"
                                                   href="#invoice_doc_<?= $doc->invoice_documentation_id ?>"
                                                   data-toggle="collapse"
                                                   target="_blank"
                                                   class="btn green  btn-outline accordion-toggle collapsed"
                                                   aria-expanded="false">
                                                    <?= $doc->filename ? $doc->filename : "View Document" ?>
                                                </a>
                                                <p id="invoice_doc_<?= $doc->invoice_documentation_id ?>"
                                                   class="panel-collapse collapse"
                                                   aria-expanded="false">
                                                    <a href="javascript:;"
                                                       class="confirmation-ship-doc btn"
                                                       data-idprefix="#invoice_doc_row"
                                                       data-id="<?= $doc->invoice_documentation_id ?>"
                                                       data-url="<?= Url::toRoute('chartering/remove_invoice_documentation/' . $doc->invoice_documentation_id) ?>"
                                                       data-message="Document successfully removed from chartering."
                                                       data-errormessage="An error occured while trying to remove document.">
                                                        <i class="fa fa-close"></i> Remove document </a>
                                                    <a class="btn btn-success"
                                                       href="<?= Yii::$app->request->baseUrl . '/' . $doc->file ?>"
                                                       target="_blank"> View document
                                                    </a>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="label label-danger">not ready</span>
                            <?php endif; ?>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"
                             style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <?= $form->field($model, 'invoice_documentations[]')->fileInput(['multiple' => true])->label(false) ?> </span>
                            <a href="javascript:;" class="btn default fileinput-exists"
                               data-dismiss="fileinput">Remove </a>
                        </div>
                    </div>
                </div>

                <div class="form-group"><?= $form->field($model, 'sof_comments')->textarea(['rows' => 8]) ?></div>

                <?php if ($model->isNewRecord): ?> </div>
            <div class="col-md-6"> <?php endif; ?>


                <div class="assigned">
                    <h3 class="page-title"> Clients
                        <small> assigned clients</small>
                    </h3>
                    <?php if (!$model->isNewRecord): ?>
                        <div class="well">
                            <?php
                            if (empty($clients)): ?>
                                <p> There are no clients assigned to this chartering </p>
                            <?php else:

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
                                        <p id="assigned_client_<?= $client->client_id ?>"
                                           class="panel-collapse collapse" aria-expanded="false">
                                            <a href="javascript:;" class="confirmation-assign btn"
                                               data-idprefix="#client_row" data-id="<?= $client->client_id ?>"
                                               data-url="<?= Url::toRoute('chartering/remove_client/' . $client->client_id) ?>"
                                               data-message="Client successfully removed from chartering."
                                               data-errormessage="An error occured while trying to reassign client."><i
                                                        class="fa fa-close"></i> Remove user from chartering </a>
                                            <a class="btn btn-success"
                                               href="<?= Url::toRoute('users/view/' . $client->client_id) ?>"
                                               target="_blank"> View client details </a>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                </div>
                <!-- CLIENT -->
                <?= $this->render('assign-form',
                    [
                        'label' => 'Client',
                        'id' => 'assignClientForm',
                        'title' => 'Assign client for chartering ',
                        'modal_id' => '#newClientModal',
                        'all' => $all_clients,
                        'value' => 'user_id',
                        'text' => 'full_name',
                        'name' => 'Clients[]',
                        'selected' => array_map(function ($el) {
                            return $el->client_id;
                        }, $clients),
                        'multiple' => true
                    ])
                ?>
                <div class="assigned">
                    <h3 class="page-title"> Companies
                        <small> assigned companies</small>
                    </h3>
                    <?php if (!$model->isNewRecord): ?>
                        <div class="well">
                            <?php
                            $companies = $model->getCharteringCompanies()->all();

                            if (empty($companies) && !$model->isNewRecord): ?>

                                <p> There are no companies assigned to this chartering </p>

                            <?php endif;

                            foreach ($companies as $company): ?>
                                <div id="company_row<?= $company->company_id ?>">
                                    <p>
                                        <a href="#assigned_company_<?= $company->company_id ?>" data-toggle="collapse"
                                           target="_blank"
                                           class="btn  grey-salsa  btn-outline accordion-toggle collapsed">
                                            <?= $company->company->company_name ?> <i class="fa fa-angle-down"></i>
                                        </a>
                                    </p>
                                    <p id="assigned_company_<?= $company->company_id ?>" class="panel-collapse collapse"
                                       aria-expanded="false" aria-expanded="false">
                                        <a href="javascript:;" class="confirmation-assign btn"
                                           data-idprefix="#company_row" data-id="<?= $company->company_id ?>"
                                           data-url="<?= Url::toRoute('chartering/remove_company/' . $company->company_id) ?>"
                                           data-message="Company successfully removed from chartering."
                                           data-errormessage="An error occured while trying to reassign company."><i
                                                    class="fa fa-close"></i> Remove company from chartering </a>
                                    </p>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>
                </div>


                <!-- COMPANY -->
                <?= $this->render('assign-form',
                    [
                        'label' => 'Company',
                        'id' => 'assignCompanyForm',
                        'title' => 'Assign company for chartering ',
                        'modal_id' => '#newCompanyModal',
                        'all' => $all_companies,
                        'value' => 'company_id',
                        'text' => 'company_name',
                        'name' => 'Companies[]',
                        'selected' => array_map(function ($el) {
                            return $el->company_id;
                        }, $companies),
                        'multiple' => true
                    ])
                ?>

                <?= $this->render('assign-form',
                    [
                        'label' => 'Broker',
                        'id' => 'assignBrokerForm',
                        'title' => 'Assign broker for chartering ',
                        'modal_id' => '#newBrokerModal',
                        'all' => $all_team,
                        'value' => 'user_id',
                        'text' => 'full_name',
                        'name' => 'broker_id',
                        'selected' => $broker,
                        'multiple' => false
                    ])
                ?>

                <?php if ($model->isNewRecord): ?> </div>
            <div class="clearfix"></div>
        </div> <?php endif; ?>
    </div>
</div>
<?php if (!$model->isNewRecord): ?>
    <div class="col-md-6">


        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">

                    <i class="icon-flag font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Current State</span>

                </div>
            </div>
            <div class="portlet-body">

                <?= $this->render('/radio-group-control', ['model' => $model, 'attribute' => 'state', 'label' => 'Current State', 'name' => 'Chartering[state]', 'values' => ['Subs Countdown' => 'subs_due', 'Fixture agreed - Live' => 'live', 'Subs failed' => 'subs_failed', 'Completed - chartering marked as past' => 'completed']]) ?>

                <div class="is-locked<?php if ($model->state != 'completed'): ?> hidden<?php endif; ?>">
                    <?= $this->render('/radio-group-control', ['model' => $model, 'attribute' => 'locked', 'label' => 'Is locked', 'name' => 'Chartering[locked]', 'values' => ['Lock' => 1, 'Unlock' => 0]]) ?>
                </div>

                <div class="clearfix"></div>

            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">

                    <i class="icon-flag font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Statuses</span>

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
                        <?= $this->render('/statuses/list', ['statuses' => $model->getCharteringStatuses()->orderby('datetime desc')->all(), 'delete' => true, 'update' => true, 'status_id' => $model->status_id, 'chartering_id' => $model->chartering_id]); ?>

                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'sof_comments')->textarea(['rows' => 8])->label('SOF comments') ?> </span>

                    </div>

                </div>
                <!--END TABS-->
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">

                    <i class="icon-flag font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Charter party</span>

                </div>
            </div>
            <div class="portlet-body">

                <input type="hidden" name="charter_party"
                       value="<?= $model->charter_party ? $model->charter_party : '' ?>"/>

                <?php $charterParty = $model->charterParty ? $model->charterParty : new CharterParty; ?>

                <?= $form->field($charterParty, 'description')->textarea(['class' => 'form-control', 'rows' => 10]) ?>

                <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </span>
                    <?= $form->field($charterParty, 'datetime')->textInput(['class' => 'form_datetime_status form-control', 'value' => $charterParty->datetime ? date('Y-m-d H:i:s', strtotime($charterParty->datetime)) : date('Y-m-d H:i:s')])->label(false) ?>
                </div>
                <p class="help-block"> Click to open calendar </p>
                <div class="clearfix"></div>


            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">

                    <i class="icon-flag font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Claims</span>


                </div>
                <div class="hide-print pull-right">
                    <a data-toggle="modal" data-target="#newClaimModal" class=" btn red btn-sm"><i
                                class="fa fa-plus"></i> Add new claim</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">

                <div class="scroller" style="height: 500px;" data-always-visible="1" data-rail-visible1="1"
                     id="claims-container">
                    <?php if (empty($model->claims)): ?>
                        <div class="well empty">There are no claims for this chartering.</div>

                    <?php else: ?>
                    <?php foreach ($model->claims as $claim): ?>


                        <?= $this->render('/claims/view', ['model' => $claim, 'actions' => true]); ?>

                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
<?php endif; ?>
<?php ActiveForm::end(); ?>


<script>
    $(document).ready(function () {

        $('input[name="Chartering[state]"]').change(function () {
            if ($(this).val() == 'completed')
                $(".is-locked").removeClass("hidden");
            else
                $(".is-locked").addClass("hidden");
        });

        Main.initDatetimePicker(".form_datetime_status");

        var vessels = [
            <?php foreach($vessels as $vessel): ?>
            {num: '<?=$vessel?>', id: '<?=$vessel; ?>'},
            <?php endforeach; ?>
        ];

        Main.initTypeahead('#typeahead_vessel', vessels, '#vessel_name');
        <?php if(!$model->isNewRecord): ?>
        Main.initConfirmation('.confirmation-ship-doc', false, {'chartering_id': <?=$model->chartering_id?>});
        <?php endif; ?>
    });

</script>



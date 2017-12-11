<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>


<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Update Operation Details
    <small> operation process</small>
</h3>
<div class="row">
    <div class="tab-content col-md-6">
        <div class="alert alert-danger display-none">
            <button class="close" data-dismiss="alert"></button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success display-none">
            <button class="close" data-dismiss="alert"></button>
            Your form validation is successful!
        </div>
        <form action="<?= Url::toRoute('operations/update/' . $model->operation_id) ?>" class="form-horizontal"
              id="operation_form" method="POST">

            <!-- SHIPS -->
            <div class="update-pane">
                <h3 class="block">Vessels details</h3>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Discharging vessel
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-ship"></i>
                    </span>
                            <input type="hidden" id="discharging_ship_id" name="discharging_ship_id"
                                   class="form-control" value="<?= $model->discharging_ship_id ?>"/>
                            <input type="text" id="typeahead_ship_discharging" name="discharging_ship"
                                   class="form-control" value="<?= $model->dischargingShip->name ?>"/></div>
                        <p class="help-block"> Enter ship name or start typing to choose an existing ship E.g: MT Alpine
                            X </p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"> Receiving vessel
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-ship"></i>
                    </span>
                            <input type="hidden" id="receiving_ship_id" name="receiving_ship_id"
                                   value="<?= $model->receiving_ship_id ?>"/>
                            <input type="text" id="typeahead_ship_receiving" name="receiving_ship" class="form-control"
                                   value="<?= $model->receivingShip->name ?>"/></div>
                        <p class="help-block"> Enter ship name or start typing to choose an existing vessel E.g: MT
                            Alpine X </p>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="update-pane">
                <h3 class="block">Provide location details</h3>
                <div class="form-group">
                    <label class="control-label col-md-3">Title
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="hidden" name="location_id" id="typeahead_location_id"
                               value="<?= $model->location_id ?>"/>
                        <input type="text" class="form-control" name="typeahead_locations" id="typeahead_locations"
                               value="<?= $model->location->title ?>"/>
                        <span class="help-block"> Provide location name </span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Longitude
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="longitude" id="longitude"
                               value="<?= $model->location->longitude ?>"/>
                        <span class="help-block"> Location longitude </span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Latitude
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="latitude" id="latitude"
                               value="<?= $model->location->latitude ?>"/>
                        <span class="help-block"> Location latitude </span>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <!-- CLIENT -->
            <div class="update-pane">
                <h3 class="block">Assign client for operation</h3>
                <div class="hide-print pull-left">
                    <a data-toggle="modal" data-target="#myModal" class=" btn red btn-sm"><i class="fa fa-plus"></i> Add
                        New Client</a>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Client
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="hidden" name="typeahead_client_id" id="typeahead_client_id"/>
                        <select name="client_id" class="form-control">
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client->user_id ?>" <?= $model->user_id == $client->user_id ? "selected" : "" ?>><?= $client->first_name . ' ' . $client->last_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>


            </div>
            <!-- REFERENCE ID -->
            <div class="update-pane">
                <h3 class="block">Enter reference ID for operation</h3>
                <div class="form-group">
                    <label class="col-md-3">Reference ID
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">

                        <input type="text" class="form-control" name="reference_id"
                               value="<?= $model->reference_id ?>"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">

                        <a href="javascript:;" class="btn green submit-btn"> Submit
                            <i class="fa fa-check"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="col-md-6">

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">

                    <i class="icon-flag font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Statuses</span>

                </div>
                <div class="hide-print pull-right">
                    <a data-toggle="modal" data-target="#myModal2" class=" btn red btn-sm"><i class="fa fa-plus"></i>
                        Change status</a>
                </div>

            </div>
            <div class="portlet-body">
                <!--BEGIN TABS-->
                <div class="tab-content">

                    <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                        <ul class="feeds op_stat">
                            <?php foreach ($model->getOperationStates()->orderby('time desc')->all() as $op_state): ?>
                                <li id="state<?= $op_state->operation_state_id ?>">

                                    <div class="row">
                                        <div class="col-md-1">
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
                                        <div class="col-md-1">
                                            <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                               href="javascript:;"
                                               data-original-title="Are you sure you want to delete operation state permanently?"
                                               data-id="<?= $op_state->operation_state_id ?>"
                                               data-message="Operation state deleted."
                                               data-errormessage="An error ocurred while tryng to delete operation state."
                                               data-url="<?= Url::toRoute("operations/update_state/" . $model->operation_id) ?>"
                                               data-placement="bottom">
                                                <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                                   title="Delete operation"></i>
                                            </a>
                                        </div>
                                    </div>

                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>

                </div>
                <!--END TABS-->
            </div>
        </div>
        <?php if ($model->report_id): ?>
            <div class="update-pane">
                <h3 class="block">Post Operation Report</h3>
                <div class="form-group">

                    <a class="btn btn-sm grey-salsa btn-outline"
                       href="<?= Yii::$app->request->baseUrl . '/' . $model->report->file ?>" target="_blank">View
                        Report Document</a>
                    <br>
                    <br>
                    <a class="btn btn-sm red-sunglo btn-outline"
                       href="<?= Url::toRoute('post-operation-reports/view/' . $model->report_id) ?>" target="_blank">View
                        Report Details</a></td>

                </div>
            </div>

        <?php endif; ?>

        <?php if ($model->invoice_id): ?>
            <div class="update-pane">
                <h3 class="block">Invoice</h3>
                <div class="form-group">

                    <a class="btn btn-sm grey-salsa btn-outline"
                       href="<?= Yii::$app->request->baseUrl . '/' . $model->invoice->file ?>" target="_blank"> View
                        Invoice Document </a>
                    <br>
                    <br>
                    <a class="btn btn-sm red-sunglo btn-outline"
                       href="<?= Url::toRoute('invoices/view/' . $model->invoice_id) ?>" target="_blank">
                        View Invoice Details
                    </a>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- CREATE CLIENT MODAL -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title modal-title"> User Details
                    <small>create account</small>
                </h3>
                <!-- END PAGE TITLE-->
            </div>
            <div class="modal-body">
                <?php

                $status_colors = $this->context->module->params["status_colors"];

                ?>
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['users/create/'],
                    'options' => ["enctype" => "multipart/form-data", "id" => "people-form"]

                ]); ?>

                <div class="portlet light bg-inverse">
                    <div class="portlet-title">
                        <div class="caption red-sunglo">
                            <span class="caption-subject font-red-sunglo bold  block pull-left"
                                  style="padding: 5px 15px 5px 0; font-size: 16px"><b>New User</b></span>

                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="portlet-body form" id="people-form">
                        <!-- BEGIN FORM-->


                        <?= $form->field($user, 'first_name',
                            [
                                'options' => ['class' => 'form-group form-md-line-input'],
                                'template' => '{input}{hint}{error}{label}',
                                'inputOptions' => ['class' => 'form-control']
                            ])
                            ->textInput(['required' => true])
                            ->label('First Name')
                            ->hint('User first name.')
                        ?>
                        <?= $form->field($user, 'last_name',
                            [
                                'options' => ['class' => 'form-group form-md-line-input'],
                                'template' => '{input}{hint}{error}{label}',
                                'inputOptions' => ['class' => 'form-control']
                            ])
                            ->textInput(['required' => true])
                            ->label('Last Name')
                            ->hint('User last name.')
                        ?>
                        <?= $form->field($user, 'email',
                            [
                                'options' => ['class' => 'form-group form-md-line-input'],
                                'template' => '{input}{hint}{error}{label}',
                                'inputOptions' => ['class' => 'form-control', 'required' => true]
                            ])
                            ->input('email')
                            ->label('Email')
                            ->hint('Email address.')
                        ?>
                        <?= $form->field($user, 'phone',
                            [
                                'options' => ['class' => 'form-group form-md-line-input'],
                                'template' => '{input}{hint}{error}{label}',
                                'inputOptions' => ['class' => 'form-control']
                            ])
                            ->textInput(['required' => false])
                            ->label('Phone')
                            ->hint('Users telephone.')
                        ?>

                        <div class="form-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <?php if (!$user->profile_picture): ?>
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                             alt=""/>
                                    <?php else: ?>
                                        <img src="<?= Yii::$app->request->baseUrl ?>/<?= $user->profile_picture ?>"
                                             alt=""/>
                                    <?php endif; ?>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px;"></div>

                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <?= $form->field($user, 'profile_picture')->fileInput()->label(false) ?> </span>
                                    <a href="javascript:;" class="btn default fileinput-exists"
                                       data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="AppUser[role]" class="md-radiobtn" value="client">
                        <div class="clearfix"></div>

                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<!-- STATUS MODAL -->

<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title modal-title"> Change state
                    <small>set operation status</small>
                </h3>
                <!-- END PAGE TITLE-->
            </div>
            <div class="modal-body">


                <div class="portlet light bg-inverse">
                    <div class="portlet-title">
                        <div class="caption red-sunglo">
                            <span class="caption-subject font-red-sunglo bold  block pull-left"
                                  style="padding: 5px 15px 5px 0; font-size: 16px"><b>Set Operation Status</b></span>

                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="portlet-body form">
                        <div class="form-group">
                            <label class="control-label col-md-4">Status
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <form action="<?= Url::toRoute('operations/update_state/' . $model->operation_id) ?>"
                                      id="status_form" method="post">
                                    <input type="hidden" name="typeahead_state_id" id="typeahead_state_id"/>
                                    <input type="text" class="form-control" name="typeahead_state"
                                           id="typeahead_state"/>
                                    <span class="help-block"> Start typing to choose existing state </span>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn green set-btn"> Set</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>

    $(document).ready(function () {

        $('.confirmation-delete').confirmation({
            container: 'body',
            btnOkClass: 'btn btn-sm btn-success',
            btnOkLabel: 'Delete ',
            btnCancelClass: 'btn btn-sm btn-danger',

            onConfirm: function () {
                var id = $(this)[0].id;
                var url = $(this)[0].url;
                var message = $(this)[0].message;
                var error_message = $(this)[0].errormessage;

                $.post(url, {"operation_state_id": id, "action": "delete"},
                    function (data) {


                        if (data.result == "success" && data.status == 200) {
                            $('#state' + id).fadeOut();
                            $('#state' + id).remove();
                            toastr.success(message);

                        } else {
                            toastr.error(data.data.error_description);
                        }

                    }, 'json'
                );
            }
        });

        $('.submit-btn').click(function () {

            $form = $('#operation_form');

            if ($form.valid() == false) {
                console.log('form not valid');
                return false;
            }


            $data = $form.serialize();

            $.post($form.attr('action'), $data, function (data) {
                if (data.result == "success" && data.status == 200) {
                    toastr.success('Operation details successfully updated.');
                    setTimeout(function () {
                        document.location = '<?=Url::toRoute("operations/")?>';
                    }, 3000);

                } else {
                    toastr.error(data.data.error_description);

                }
            });
        });

        $('.set-btn').click(function () {

            $form = $('#status_form');


            $data = $form.serialize();

            console.log($form.attr('action'));
            console.log($data);

            $.post($form.attr('action'), $data, function (data) {
                if (data.result == "success" && data.status == 200) {
                    toastr.success('Operation state successfully set.');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);

                } else {
                    toastr.error(data.data.error_description);

                }
            });

        });


        var ships = new Bloodhound({
            datumTokenizer: function (d) {
                return Bloodhound.tokenizers.whitespace(d.num);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: [
                <?php foreach($ships as $ship): ?>
                {num: '<?=$ship->name?>', id: <?=$ship->ship_id?> },
                <?php endforeach; ?>

            ]
        });

        var locations = new Bloodhound({
            datumTokenizer: function (d) {
                return Bloodhound.tokenizers.whitespace(d.num);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: [
                <?php foreach($locations as $location): ?>
                {
                    num: '<?=$location->title?>',
                    longitude: <?=$location->longitude?>,
                    latitude: <?=$location->latitude?>,
                    id: <?=$location->location_id?>  },
                <?php endforeach; ?>

            ]
        });

        var states = new Bloodhound({
            datumTokenizer: function (d) {
                return Bloodhound.tokenizers.whitespace(d.num);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: [
                <?php foreach($states as $state): ?>
                {num: '<?=$state->description?>', id: <?=$state->state_id?>  },
                <?php endforeach; ?>

            ]
        });

        // initialize the bloodhound suggestion engine
        ships.initialize();
        locations.initialize();
        states.initialize();

        $('#typeahead_ship_discharging').typeahead(null, {
            displayKey: 'num',
            hint: (App.isRTL() ? false : true),
            source: ships.ttAdapter()
        });

        $('#typeahead_ship_receiving').typeahead(null, {
            displayKey: 'num',
            hint: (App.isRTL() ? false : true),
            source: ships.ttAdapter()
        });

        $('#typeahead_locations').typeahead(null, {
            displayKey: 'num',
            hint: (App.isRTL() ? false : true),
            source: locations.ttAdapter()
        });

        $('#typeahead_state').typeahead(null, {
            displayKey: 'num',
            hint: (App.isRTL() ? false : true),
            source: states.ttAdapter()
        });

        $('#typeahead_locations').bind('typeahead:select', function (ev, suggestion) {
            $('#longitude').val(suggestion.longitude);
            $('#latitude').val(suggestion.latitude);
            $('#typeahead_location_id').val(suggestion.id);
        });

        $('#typeahead_state').bind('typeahead:select', function (ev, suggestion) {

            $('#typeahead_state_id').val(suggestion.id);
        });

        $('#typeahead_ship_receiving').bind('typeahead:select', function (ev, suggestion) {
            $('#receiving_ship_id').val(suggestion.id);
            console.log(suggestion.id);
        });

        $('#typeahead_ship_discharging').bind('typeahead:select', function (ev, suggestion) {
            $('#discharging_ship_id').val(suggestion.id);

            console.log(suggestion.id);
        });


    });

</script>   

<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<!-- BEGIN PAGE HEADER-->


<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Create New Operation
    <small>start operation process</small>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-red"></i>
                    <span class="caption-subject font-red bold uppercase"> Operation Wizard -
                                            <span class="step-title"> Step 1 of 5 </span>
                                        </span>
                </div>
                <div class="actions">
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                        <i class="icon-cloud-upload"></i>
                    </a>
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                        <i class="icon-wrench"></i>
                    </a>
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                        <i class="icon-trash"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="<?= Url::toRoute('operations/create') ?>" class="form-horizontal" id="operation_form"
                      method="POST">
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                                                <i class="fa fa-check"></i> Ships Setup </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number"> 2 </span>
                                        <span class="desc">
                                                                <i class="fa fa-check"></i> Location Setup </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab3" data-toggle="tab" class="step active">
                                        <span class="number"> 3 </span>
                                        <span class="desc">
                                                                <i class="fa fa-check"></i> Client Setup </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab4" data-toggle="tab" class="step active">
                                        <span class="number"> 4 </span>
                                        <span class="desc">
                                                                <i class="fa fa-check"></i> Reference ID </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab5" data-toggle="tab" class="step">
                                        <span class="number"> 5 </span>
                                        <span class="desc">
                                                                <i class="fa fa-check"></i> Confirm </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-danger display-none">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                </div>
                                <div class="alert alert-success display-none">
                                    <button class="close" data-dismiss="alert"></button>
                                    Your form validation is successful!
                                </div>
                                <!-- SHIPS -->
                                <div class="tab-pane active" id="tab1">
                                    <h3 class="block">Provide vessels details</h3>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Discharging vessel
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-ship"></i>
                                                                    </span>
                                                <input type="hidden" id="discharging_ship_id" name="discharging_ship_id"
                                                       class="form-control"/>
                                                <input type="text" id="typeahead_ship_discharging"
                                                       name="discharging_ship" class="form-control"/></div>
                                            <p class="help-block"> Enter ship name or start typing to choose an existing
                                                ship E.g: MT Alpine X </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Receiving vessel
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-ship"></i>
                                                                    </span>
                                                <input type="hidden" id="receiving_ship_id" name="receiving_ship_id"/>
                                                <input type="text" id="typeahead_ship_receiving" name="receiving_ship"
                                                       class="form-control"/></div>
                                            <p class="help-block"> Enter ship name or start typing to choose an existing
                                                vessel E.g: MT Alpine X </p>
                                        </div>
                                    </div>

                                </div>

                                <!-- LOCATION -->
                                <div class="tab-pane" id="tab2">
                                    <h3 class="block">Provide location details</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Title
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="hidden" name="location_id" id="typeahead_location_id"/>
                                            <input type="text" class="form-control" name="typeahead_locations"
                                                   id="typeahead_locations"/>
                                            <span class="help-block"> Provide location name </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Longitude
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="longitude" id="longitude"/>
                                            <span class="help-block"> Provide longitude for location </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Latitude
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="latitude" id="latitude"/>
                                            <span class="help-block"> Provide latitude for location </span>
                                        </div>
                                    </div>

                                </div>
                                <!-- CLIENT -->
                                <div class="tab-pane" id="tab3">
                                    <h3 class="block">Assign client for operation</h3>
                                    <div class="pull-left hide-print">
                                        <a data-toggle="modal" data-target="#myModal" class=" btn red btn-sm"><i
                                                    class="fa fa-plus"></i> Add New Client</a>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Client
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="hidden" name="typeahead_client_id" id="typeahead_client_id"/>
                                            <select name="client_id" class="form-control">
                                                <?php foreach ($clients as $client): ?>
                                                    <option value="<?= $client->user_id ?>"><?= $client->first_name . ' ' . $client->last_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- <input type="text" class="form-control" name="typeahead_clients" id="typeahead_clients"/>
                                          <span class="help-block"> Start typing to choose existing client ex. Steve Lewis</span> -->
                                        </div>
                                    </div>

                                </div>
                                <!-- REFERENCE ID -->
                                <div class="tab-pane" id="tab4">
                                    <h3 class="block">Enter reference ID for operation</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Reference ID
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">

                                            <input type="text" class="form-control" name="reference_id"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONFIRM -->
                                <div class="tab-pane" id="tab5">
                                    <h3 class="block">Confirm operation details</h3>
                                    <h4 class="form-section">Operation Details</h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Reference ID:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="reference_id"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Client:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="client_id"></p>
                                        </div>
                                    </div>
                                    <h4 class="form-section">Vessels</h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Discharging vessel:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="discharging_ship"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Receiving vessel:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="receiving_ship"></p>
                                        </div>
                                    </div>
                                    <h4 class="form-section">Location</h4>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Location:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="typeahead_locations"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Longitude:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="longitude"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Latitude:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="latitude"></p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <a href="javascript:;" class="btn default button-previous">
                                        <i class="fa fa-angle-left"></i> Back </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <a href="javascript:;" class="btn green submit-btn"> Submit
                                        <i class="fa fa-check"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        var ships = new Bloodhound({
            datumTokenizer: function (d) {
                return Bloodhound.tokenizers.whitespace(d.num);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: [
                <?php foreach($ships as $ship): ?>
                {
                    num: '<?=$ship->getOngoingOperation() ? $ship->name . " (busy)" : $ship->name?>',
                    id: <?=$ship->ship_id?>,
                    busy: <?=$ship->getOngoingOperation() ? 'true' : 'false'?>,
                    reference_id: '<?=$ship->getOngoingOperation() ? $ship->getOngoingOperation()->reference_id : ""?>',
                    url: '<?=$ship->getOngoingOperation() ? Url::toRoute("operations/view/" . $ship->getOngoingOperation()->operation_id) : ""?>',
                },
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

        // initialize the bloodhound suggestion engine
        ships.initialize();
        locations.initialize();


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


        $('#typeahead_locations').bind('typeahead:select', function (ev, suggestion) {
            $('#longitude').val(suggestion.longitude);
            $('#latitude').val(suggestion.latitude);
            $('#typeahead_location_id').val(suggestion.id);
        });
        $('#typeahead_ship_receiving').bind('typeahead:select', function (ev, suggestion) {

            if (suggestion.busy == true) {
                $(this).typeahead("val", "");
                toastr.error('You can not choose this vessel because it is already involved in ongoing operation with reference id ' + suggestion.reference_id + '. <a href="' + suggestion.url + '" class="btn btn-default grey" target="_blank">View details</a>')
            } else {
                $('#receiving_ship_id').val(suggestion.id);
            }
        });
        $('#typeahead_ship_discharging').bind('typeahead:select', function (ev, suggestion) {

            if (suggestion.busy == true) {
                $(this).typeahead("val", "");
                toastr.error('You can not choose this vessel because it is already involved in ongoing operation with reference id ' + suggestion.reference_id + '. <a href="' + suggestion.url + '" class="btn btn-default grey" target="_blank">View details</a>')
            } else {
                $('#discharging_ship_id').val(suggestion.id);
            }
            console.log(suggestion);
        });


    });

    var FormWizardOp = function () {


        return {
            //main function to initiate the module
            init: function () {
                if (!jQuery().bootstrapWizard) {
                    return;
                }

                var form = $('#operation_form');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);

                form.validate({
                    doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    rules: {
                        //account
                        username: {
                            minlength: 5,
                            required: true
                        },
                        discharging_ship: {
                            minlength: 5,
                            required: true
                        },
                        receiving_ship: {
                            minlength: 5,
                            required: true,
                            notEqualTo: "#typeahead_ship_discharging"
                        },

                    },
                    invalidHandler: function (event, validator) { //display error alert on form submit   
                        success.hide();
                        error.show();
                        App.scrollTo(error, -200);
                    },

                    highlight: function (element) { // hightlight error inputs
                        $(element)
                            .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                    },

                    unhighlight: function (element) { // revert the change done by hightlight
                        $(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                    },

                    success: function (label) {
                        if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                            label
                                .closest('.form-group').removeClass('has-error').addClass('has-success');
                            label.remove(); // remove error label here
                        } else { // display success icon for other inputs
                            label
                                .addClass('valid') // mark the current input as valid and display OK icon
                                .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                        }
                    },

                    submitHandler: function (form) {
                    }

                });

                var displayConfirm = function () {

                    $('#tab5 .form-control-static', form).each(function () {
                        console.log($(this).attr("data-display"));

                        var input = $('[name="' + $(this).attr("data-display") + '"]', form);
                        console.log(input.val());
                        if (input.is(":radio")) {
                            input = $('[name="' + $(this).attr("data-display") + '"]:checked', form);
                        }
                        if (input.is(":text") || input.is("textarea")) {
                            $(this).html(input.val());
                        } else if (input.is("select")) {
                            $(this).html(input.find('option:selected').text());
                        } else if (input.is(":radio") && input.is(":checked")) {
                            $(this).html(input.attr("data-title"));
                        }
                    });
                }

                var handleTitle = function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    // set wizard title
                    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                    // set done steps
                    jQuery('li', $('#form_wizard_1')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }

                    if (current == 1) {
                        $('#form_wizard_1').find('.button-previous').hide();
                    } else {
                        $('#form_wizard_1').find('.button-previous').show();
                    }

                    if (current >= total) {
                        $('#form_wizard_1').find('.button-next').hide();
                        $('#form_wizard_1').find('.submit-btn').show();
                        displayConfirm();
                    } else {
                        $('#form_wizard_1').find('.button-next').show();
                        $('#form_wizard_1').find('.submit-btn').hide();
                    }
                    App.scrollTo($('.page-title'));
                }

                // default form wizard
                $('#form_wizard_1').bootstrapWizard({
                    'nextSelector': '.button-next',
                    'previousSelector': '.button-previous',
                    onTabClick: function (tab, navigation, index, clickedIndex) {
                        return false;

                        success.hide();
                        error.hide();
                        if (form.valid() == false) {
                            return false;
                        }

                        handleTitle(tab, navigation, clickedIndex);
                    },
                    onNext: function (tab, navigation, index) {
                        success.hide();
                        error.hide();

                        if (form.valid() == false) {
                            return false;
                        }


                        handleTitle(tab, navigation, index);
                    },
                    onPrevious: function (tab, navigation, index) {
                        success.hide();
                        error.hide();

                        handleTitle(tab, navigation, index);
                    },
                    onTabShow: function (tab, navigation, index) {
                        var total = navigation.find('li').length;
                        var current = index + 1;
                        var $percent = (current / total) * 100;
                        $('#form_wizard_1').find('.progress-bar').css({
                            width: $percent + '%'
                        });
                    }
                });

                $('#form_wizard_1').find('.button-previous').hide();

                $('#form_wizard_1 .submit-btn').click(function () {
                    //alert('Finished! Hope you like it :)');

                    $form = $('#operation_form');
                    $data = $form.serialize();

                    $.post($form.attr('action'), $data, function (data) {
                        if (data.result == "success" && data.status == 200) {
                            toastr.success('Operation successfully created.');
                            //   setTimeout( function(){document.location = '<?=Url::toRoute("operations/")?>';}, 3000 );

                        } else {
                            toastr.error(data.data.error_description);

                        }
                    });

                }).hide();

            }

        };

    }();

    jQuery(document).ready(function () {
        FormWizardOp.init();
    });

</script>


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


                <script type="text/javascript">
                    $(function () {

                        $('form#people-form').submit(function () {

                            $form = $(this);
                            $data = new FormData(this);

                            $.ajax({
                                url: $form.attr('action'),
                                type: "POST",
                                data: $data,
                                dataType: 'json',
                                contentType: false,
                                cache: false,
                                processData: false,
                                statusCode: {
                                    500: function () {
                                        toastr.error('An error occurred while trying to save user details.');
                                        return false;
                                    },
                                    200: function (data) {
                                        if (data.result == "success" && data.status == 200) {
                                            toastr.success('User account successfully created. ');
                                            $('#myModal').modal('hide');
                                            $('select[name="client_id"]').append($("<option selected></option>")
                                                .attr("value", data.data.user_id)
                                                .text(data.data.first_name + ' ' + data.data.last_name));

                                        } else {
                                            toastr.error(data.data.error_description);

                                        }

                                        return false;
                                    },
                                },


                            });


                            return false;
                        });
                    });


                </script>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn green"> Save Changes</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
            <?php ActiveForm::end(); ?>
            <!-- END FORM-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
            
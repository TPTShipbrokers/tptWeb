<?php

use app\models\Location;
use app\models\WeatherReport;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];
$model = new Location;

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Locations
    <small>locations & statistics</small>
</h3>
<!-- END PAGE TITLE-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Locations</b></span>
                <!-- treba da se otvori forma -->
                <div class="pull-left hide-print">
                    <a class="accordion-toggle collapsed btn red btn-sm" data-toggle="collapse"
                       data-parent="#accordion1" href="#accordion_create" aria-expanded="false">
                        <i class="fa fa-plus"></i> Add New Location</a>
                </div>
                <div class="pull-right hide-print">
                    <a href="#" class="export btn btn-success btn-sm"><i class="fa fa-bars"></i> Export Table Data into
                        CSV</a>
                    <div class="btn-group info">
                        <button class="btn btn-success btn-sm" onclick="windowPrint()"><i class="fa fa-print"></i> Print
                        </button>

                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            <div id="accordion_create" class="panel-collapse collapse" aria-expanded="false">

                <div class="well ">

                    <?php $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['locations/create/'],
                        'options' => ["enctype" => "multipart/form-data", 'class' => 'form-inline', 'id' => 'newLocationForm']

                    ]); ?>

                    <?= $form->field($model, 'title',
                        [
                            'options' => ['class' => 'form-group form-md-line-input'],
                            'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
                            'inputOptions' => ['class' => 'form-control']
                        ])
                        ->textInput(['required' => true, 'placeholder' => 'Location Name'])
                        ->label(false)
                        ->hint('Location name.')
                    ?>

                    <?= $form->field($model, 'longitude',
                        [
                            'options' => ['class' => 'form-group form-md-line-input'],
                            'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
                            'inputOptions' => ['class' => 'form-control', 'step' => 'any', 'required' => true, 'placeholder' => 'Location Longitude', 'type' => 'number']
                        ])
                        ->input('number')
                        ->label(false)
                        ->hint('Location longitude.')
                    ?>

                    <?= $form->field($model, 'latitude',
                        [
                            'options' => ['class' => 'form-group form-md-line-input'],
                            'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
                            'inputOptions' => ['class' => 'form-control', 'step' => 'any', 'required' => true, 'placeholder' => 'Location Latitude', 'type' => 'number']
                        ])
                        ->input('number')
                        ->label(false)
                        ->hint('Location latitude.')
                    ?>

                    <button type="button" class="btn green" onclick="create()"> Save</button>
                    <a data-toggle="collapse" data-parent="#accordion1" href="#accordion_create" aria-expanded="false"
                       class="btn default accordion-toggle collapsed "> Cancel </a>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover table-advance" id="dataTableUsers">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th>Weather Reports</th>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data["locations"] as $location): ?>
                            <tr class="odd" id="row<?= $location['location_id'] ?>">
                                <td><?= $location['title'] ?></td>
                                <td><?= $location['longitude'] ?></td>
                                <td><?= $location['latitude'] ?></td>
                                <td style="min-width:950px">
                                    <?php if ($location['weather_reports']): ?>
                                        <div class="scroller" style="height: 290px;min-width:950px"
                                             data-always-visible="1" data-rail-visible1="1">
                                            <ul class="feeds op_stat" style="min-width:950px">

                                                <li>
                                                    <div class="row text-center">
                                                        <div class="col-md-1">
                                                            <b>SURF</b>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <b>SURF DIR</b>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <b>SEAS</b>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <b>PERIOD</b>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <b>WIND</b>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <b>WND/DIR</b>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <b>COMMENT</b>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="date"><b>DATE / TIME</b></div>
                                                        </div>
                                                        <div class="col-md-2">

                                                        </div>
                                                    </div>
                                                    <?php foreach ($location['weather_reports'] as $weather_report): ?>
                                                        <div class="row text-center"
                                                             id="weather_report<?= $weather_report['weather_report_id'] ?>">
                                                            <div class="col-md-1">
                                                                <?= $weather_report['surf_min'] ?>
                                                                - <?= $weather_report['surf_max'] ?>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <?= $weather_report['surf_dir'] ?> <?= $weather_report['surf_deg'] ?>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <?= $weather_report['seas'] ?>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <?= $weather_report['period'] ?>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <?= $weather_report['wind_min'] ?>
                                                                - <?= $weather_report['wind_max'] ?>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <?= $weather_report['wind_dir'] ?> <?= $weather_report['wind_deg'] ?>
                                                            </div>
                                                            <div class="col-md-2"
                                                                 id="comment_field<?= $weather_report['weather_report_id'] ?>">
                                                                <?= $weather_report['comment'] ?>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="date"> <?= date('d M, Y H:i', strtotime($weather_report['datetime'])) ?> </div>
                                                            </div>
                                                            <div class="col-md-2">

                                                                <a class="btn btn-circle btn-icon-only blue accordion-toggle collapsed"
                                                                   data-toggle="collapse"
                                                                   data-parent="#accordion1"
                                                                   href="#accordion_comment<?= $weather_report['weather_report_id'] ?>"
                                                                   aria-expanded="false">
                                                                    <i class="fa fa-comment" data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Add comment for weather report"></i>
                                                                </a>

                                                                <a class="btn btn-circle btn-icon-only green"
                                                                   onClick="openEditWeatherReportModal('<?= Url::toRoute('locations/update_weather_report/' . $weather_report['weather_report_id']) ?>', '<?= Url::toRoute('locations/update/' . $location['location_id']) ?>')">
                                                                    <i class="icon-wrench" data-toggle="tooltip"
                                                                       data-placement="top" title=""
                                                                       data-original-title="Edit Weather Report Details"></i>
                                                                </a>

                                                                <a class="btn btn-circle btn-icon-only red confirmation-delete-weather"
                                                                   href="javascript:"
                                                                   data-original-title="Are you sure you want to delete weather report permanently?"
                                                                   data-id="<?= $weather_report['weather_report_id'] ?>"
                                                                   data-message="Weather report deleted."
                                                                   data-errormessage="An error ocurred while tryng to delete weather report."
                                                                   data-url="<?= Url::toRoute("locations/update_weather_report/" . $weather_report['weather_report_id']) ?>"
                                                                   data-placement="bottom">
                                                                    <i class="icon-trash" data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Delete weather report"></i>
                                                                </a>


                                                            </div>
                                                        </div>
                                                        <div id="accordion_comment<?= $weather_report['weather_report_id'] ?>"
                                                             class="panel-collapse collapse" aria-expanded="false">

                                                            <div class="well ">

                                                                <?php $form = ActiveForm::begin([
                                                                    'method' => 'post',
                                                                    'action' => ['locations/update_weather_report/'],
                                                                    'options' => ['class' => 'comment-form', 'data-comment_id' => $weather_report['weather_report_id']]

                                                                ]); ?>

                                                                <input type="hidden" name="weather_report_id"
                                                                       value="<?= $weather_report['weather_report_id'] ?>"/>
                                                                <input type="hidden" name="action" value="comment"/>
                                                                <?php
                                                                $wr = new WeatherReport;
                                                                $wr->comment = $weather_report['comment'];
                                                                echo $form->field($wr, 'comment',
                                                                    [
                                                                        'options' => ['class' => 'form-group form-md-line-input'],
                                                                        'template' => '{input}{hint}{error}{label}',
                                                                        'inputOptions' => ['class' => 'form-control']
                                                                    ])
                                                                    ->textArea(['required' => false, 'maxlength' => 300, 'rows' => 3, 'cols' => 10])
                                                                    ->label('Comment')
                                                                    ->hint('Weather Report Comment.')
                                                                ?>

                                                                <button type="submit" class="btn green"> Save</button>
                                                                <a data-toggle="collapse" data-parent="#accordion1"
                                                                   href="#accordion_comment" aria-expanded="false"
                                                                   class="btn default accordion-toggle collapsed ">
                                                                    Cancel </a>

                                                                <?php ActiveForm::end(); ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>


                                                </li>


                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                </td>


                                <td class="hide-print">
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only blue"
                                           onClick="openWeatherModal('<?= Url::toRoute('locations/update/' . $location['location_id']) ?>')">
                                            <i class="fa fa-sun-o" data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Add Weather Report"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only green"
                                           onClick="openEditModal('<?= $location['title'] ?>',<?= $location['longitude'] ?>,<?= $location['latitude'] ?>,'<?= Url::toRoute('locations/update/' . $location['location_id']) ?>')">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Edit Location Details"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:"
                                           data-original-title="Are you sure you want to delete location permanently?"
                                           data-id="<?= $location['location_id'] ?>" data-message="Location deleted."
                                           data-errormessage="An error ocurred while tryng to delete location."
                                           data-url="<?= Url::toRoute("locations/delete") ?>" data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete location"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- EDIT LOCATION Modal -->
<div id="edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Location Details</h4>
            </div>
            <div class="modal-body">
                <form class="form" role="form" action="" method="post" enctype="multipart/form-data" id="edit-form">
                    <div class="form-group form-md-line-input has-success">
                        <input type="text" class="form-control" id="edit-title-field" name="Location[title]">
                        <div class="form-control-focus"></div>
                    </div>
                    <div class="form-group form-md-line-input has-success">
                        <input type="number" step="any" class="form-control" id="edit-longitude-field"
                               name="Location[longitude]">
                        <div class="form-control-focus"></div>
                    </div>
                    <div class="form-group form-md-line-input has-success">
                        <input type="number" step="any" class="form-control" id="edit-latitude-field"
                               name="Location[latitude]">
                        <div class="form-control-focus"></div>
                    </div>

                    <button type="button" class="btn btn-danger" onClick="update()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>

            </div>

        </div>

    </div>
</div>

<!-- EDIT LOCATION Modal -->
<div id="edit-weather-report-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Weather Report Details</h4>
            </div>
            <div class="modal-body">


            </div>

        </div>

    </div>
</div>

<div id="report-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add weather report</h4>
            </div>
            <div class="modal-body">
                <div class="tabbable-line tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab"> Enter weather report details </a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab"> Paste weather reports from file </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <?php echo $this->render('weather_report_form', ['model' => new WeatherReport]); ?>
                        </div>
                        <div class="tab-pane " id="tab_1_3">
                            <form class="form" role="form" action="" method="post" id="report-form-parse"
                                  data-action="textual">
                                <div class="form-group form-md-line-input has-success">
                                    <textarea class="form-control" id="report-content"
                                              name="Location[report]"></textarea>
                                    <div class="form-control-focus"></div>
                                </div>


                                <button type="button" class="btn btn-danger"
                                        onClick="addWeatherReport('#report-form-parse')">Save
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>


                </div>

            </div>

        </div>

    </div>
</div>

<script>


    $(document).ready(function () {

        toastr.options.closeDuration = 50;

        $(".form_datetime_event").datetimepicker({
            autoclose: true,
            isRTL: App.isRTL(),
            format: "yyyy-mm-dd hh:ii",
            pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
        });

        Main.initDatatable('#dataTableUsers');

        Main.initConfirmation('.confirmation-delete');

        $('.confirmation-delete-weather').confirmation(
            {
                container: 'body',
                btnOkClass: 'btn btn-sm btn-success',
                btnOkLabel: 'Delete ',
                btnCancelClass: 'btn btn-sm btn-danger',

                onConfirm: function () {
                    var id = $(this)[0].id;
                    var url = $(this)[0].url;
                    var message = $(this)[0].message;
                    var error_message = $(this)[0].errormessage;

                    $.post(url, {"weather_report_id": id, "action": "delete"},
                        function (data) {


                            if (data.result == 'success') {
                                $('#weather_report' + id).fadeOut();
                                $('#weather_report' + id).remove();
                                toastr.success(message);

                            } else {
                                toastr.error(data.message + ' ' + data.data.error_description);
                            }

                        }, 'json'
                    );
                }
            });


        $('#edit-form').submit(function () {
            update();
            return false;
        });

        $('.comment-form').submit(function (e) {

            $form = $(this);
            $id = $form.data('comment_id');
            $url = $form.attr('action');

            $.post($url, $form.serialize(),

                function (data) {


                    if (data.result == 'success') {

                        toastr.success('Comment successfully added.');
                        $('#accordion_comment' + $id).collapse('hide');
                        $('#comment_field' + $id).html($form.find('textarea').val());

                    } else {
                        toastr.error(data.message + '<br>' + data.data.error_description);
                    }

                    return false;

                }, 'json'
            );

            return false;
        });

    });


    function create() {

        $form = $('#newLocationForm');
        $url = $form.attr('action');

        $.post($url, $form.serialize(),
            function (data) {


                if (data.result == 'success') {

                    toastr.success('New location successfully created.');

                    setTimeout(function () {
                        document.location = '<?=Url::toRoute("locations/")?>';
                    }, 3000);

                } else {
                    toastr.error(data.message + '<br>' + data.data.error_description);
                }

            }, 'json'
        );
    }

    function openEditModal($title, $longitude, $latitude, $action) {
        $("#edit-title-field").val($title)
        $("#edit-longitude-field").val($longitude);
        $("#edit-latitude-field").val($latitude);;
        $("#edit-form").attr('action', $action);;
        $("#edit-modal").modal("show");
    }

    function openEditWeatherReportModal($url, $action) {
        $.get($url, {}, function (data) {
            $('#edit-weather-report-modal .modal-body').html(data);
            $("#report-form").attr('action', $action);
            $("#edit-weather-report-modal").modal("show");
            $(".form_datetime_event").datetimepicker({
                autoclose: true,
                isRTL: App.isRTL(),
                format: "yyyy-mm-dd hh:ii",
                pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
            });

        });
    }

    function openWeatherModal($action) {
        $('#report-content').val('');
        $("#report-form-parse").attr('action', $action);
        $("#report-form").attr('action', $action);
        console.log($action);
        $("#report-modal").modal("show");

    }

    function addWeatherReport(form_id) {
        $form = $(form_id);
        $action = $form.data('action');
        $url = $form.attr('action');

        $date = $(".form_datetime_event").data("datetimepicker").getDate();

        $date_formatted = $date.getFullYear() + "-" + ($date.getMonth() + 1) + "-" + $date.getDate() + " " + $date.getHours() + ":" + $date.getMinutes() + ":" + $date.getSeconds();
        console.log($date_formatted);

        $data = $form.serialize();

        if ($action == 'manual')
            $data += "&WeatherReport[datetime]=" + $date_formatted;

        $.post($url, $data,
            function (data) {


                if (data.result == 'success') {

                    $("#report-modal").modal("hide");

                    toastr.success('Changes successfully saved.');
                    setTimeout(function () {
                        document.location = '<?=Url::toRoute("locations/")?>';
                    }, 3000);

                } else {
                    toastr.error(data.message + '<br>' + data.data.error_description);
                    console.log(data);
                }

            }, 'json'
        );
    }

    function update() {
        $form = $('#edit-form');
        $url = $form.attr('action');

        $.post($url, $form.serialize(),
            function (data) {


                if (data.result == 'success') {

                    $("#edit-modal").modal("hide");

                    toastr.success('Location details successfully updated.');
                    setTimeout(function () {
                        document.location = '<?=Url::toRoute("locations/")?>';
                    }, 3000);

                } else {
                    toastr.error(data.message + '<br>' + data.data.error_description);
                }

            }, 'json'
        );
    }


</script>
<?php

use app\models\Ship;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];
$model = new Ship;

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Ships
    <small>ships & statistics</small>
</h3>
<!-- END PAGE TITLE-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Ships</b></span>
                <!-- treba da se otvori forma -->
                <div class="pull-left hide-print">
                    <a class="accordion-toggle collapsed btn red btn-sm" data-toggle="collapse"
                       data-parent="#accordion1" href="#accordion_create" aria-expanded="false">
                        <i class="fa fa-plus"></i> Add New Ship</a>
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
                        'action' => ['ships/create/'],
                        'options' => ["enctype" => "multipart/form-data", 'class' => 'form-inline', 'id' => 'newShipForm']

                    ]); ?>

                    <?= $form->field($model, 'name',
                        [
                            'options' => ['class' => 'form-group form-md-line-input'],
                            'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
                            'inputOptions' => ['class' => 'form-control']
                        ])
                        ->textInput(['required' => true, 'placeholder' => 'Ship Name'])
                        ->label(false)
                        ->hint('Ship name.')
                    ?>

                    <button type="button" class="btn green" onclick="saveShip()"> Save</button>
                    <a data-toggle="collapse" data-parent="#accordion1" href="#accordion_create" aria-expanded="false"
                       class="btn default accordion-toggle collapsed "> Cancel </a>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <style>
                    table.dataTable tbody td, table.dataTable tbody th {
                        position: relative;
                        border: none;
                    }
                </style>

                <div class="dataTable_wrapper">
                    <table class="table table-hover table-advance" id="dataTableUsers" style="border-spacing: 10px">
                        <thead class="well">
                        <tr>
                            <th>Name</th>
                            <th>Activity</th>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data["ships"] as $ship): ?>
                            <tr class="odd" id="row<?= $ship['ship_id'] ?>">
                                <td><?= $ship['name'] ?></td>
                                <td>
                                    <?php if ($ship['activity'] == 'no activity'): ?>
                                        <div class="well">
                                            <div class="row mar0">
                                                <div class="col-md-4">
                                                <span class="label label-default label-sm" style="color: white">
                                                    <?= $ship['activity'] ?>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="well">

                                            <div class="row mar0">
                                                <div class="col-md-4">
                                                <span class="label label-success label-sm" style="color: white"> 
                                                    <a href="<?= Url::toRoute('operations/view/' . $ship['activity']['operation']->operation_id) ?>"
                                                       target="_blank" style="color: white;text-decoration: none"
                                                       class="hide-print">
                                                        View operation details <i class="fa fa-share"
                                                                                  style="color: white"></i>
                                                    </a>
                                                </span>
                                                </div>

                                                <div class="col-md-6">

                                                    <?= $ship['activity']['operation']->dischargingShip->name . ' - ' . $ship['activity']['operation']->receivingShip->name ?>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>

                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="hide-print">
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only green"
                                           onClick="openEditModal('<?= $ship['name'] ?>','<?= Url::toRoute('ships/update/' . $ship['ship_id']) ?>')">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Edit Ship Details"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:"
                                           data-original-title="Are you sure you want to delete ship permanently?"
                                           data-id="<?= $ship['ship_id'] ?>" data-message="Ship deleted."
                                           data-errormessage="An error ocurred while tryng to delete ship."
                                           data-url="<?= Url::toRoute("ships/delete") ?>" data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete ship"></i>
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
<!-- Modal -->
<div id="edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Ship Details</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline margin-bottom-40" role="form" action="" method="post"
                      enctype="multipart/form-data" id="edit-form">
                    <div class="form-group form-md-line-input has-success">
                        <input type="text" class="form-control" id="edit-name-field" name="Ship[name]">
                        <div class="form-control-focus"></div>
                    </div>

                    <button type="button" class="btn btn-danger" onClick="updateShip()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>

            </div>

        </div>

    </div>
</div>

<script>


    $(document).ready(function () {

        toastr.options.closeDuration = 50;


        $('.confirmation-delete').confirmation(
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

                    $.post(url, {"ship_id": id},
                        function (data) {


                            if (data.result == 'success') {
                                $('#row' + id).fadeOut();
                                $('#row' + id).remove();
                                toastr.success(message);

                            } else {
                                toastr.error(data.message + ' ' + data.data.error_description);
                            }

                        }, 'json'
                    );
                }
            });

        var table = $('#dataTableUsers').DataTable({
            responsive: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

        });

        $('#edit-form').submit(function () {
            updateShip();
            return false;
        });

    });

    function saveShip() {
        $form = $('#newShipForm');
        $url = $form.attr('action');

        $.post($url, $form.serialize(),
            function (data) {


                if (data.result == 'success') {

                    toastr.success('New ship successfully created.');

                    setTimeout(function () {
                        document.location = '<?=Url::toRoute("ships/")?>';
                    }, 3000);

                } else {
                    toastr.error(data.message + '<br>' + data.data.error_description);
                }

            }, 'json'
        );

    }


    function ex() {
        var csv = $('#dataTableUsers').table2CSV({delivery: 'value'});
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        return csvData;
    }

    function openEditModal($name, $action) {
        $("#edit-name-field").val($name)
        $("#edit-form").attr('action', $action);
        $("#edit-modal").modal("show");
    }

    function updateShip() {
        $form = $('#edit-form');
        $url = $form.attr('action');

        $.post($url, $form.serialize(),
            function (data) {


                if (data.result == 'success') {

                    $("#edit-modal").modal("hide");

                    toastr.success('Ship details successfully updated.');
                    setTimeout(function () {
                        document.location = '<?=Url::toRoute("ships/")?>';
                    }, 3000);

                } else {
                    toastr.error(data.message + '<br>' + data.data.error_description);
                }

            }, 'json'
        );

    }


    $(".export").on('click', function (event) {
        // CSV
        $(this)
            .attr({
                'download': 'Ships.csv',
                'href': ex(),
                'target': '_blank'
            });
    });
</script>
<?php

use app\models\Invoice;
use app\models\Location;
use yii\helpers\Url;

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];
$model = new Location;

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Invoices
    <small>invoices & statistics</small>
</h3>
<!-- END PAGE TITLE-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Invoices</b></span>
                <!-- treba da se otvori forma -->
                <div class="pull-left hide-print">
                    <a class="accordion-toggle collapsed btn red btn-sm" href="<?= Url::toRoute('invoices/create') ?>">
                        <i class="fa fa-plus"></i> Add New Invoice</a>
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

            <div class="panel-body">

                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-advance table-hover" id="dataTableUsers">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-briefcase"></i> Invoice ID
                            </th>
                            <th>
                                <i class="fa fa-info-circle"></i> Operation
                            </th>
                            <th>
                                <i class="fa fa-clock-o"></i> Date
                            </th>
                            <th>
                                <i class="fa fa-usd"></i>
                                Total
                            </th>
                            <th>
                                <i class="fa fa-minus"></i>
                                Less
                            </th>
                            <th>
                                <i class="fa fa-usd"></i>
                                Net Amount
                            </th>
                            <th>
                                <i class="fa fa-question"></i>
                                Status
                            </th>
                            <th>
                                <i class="fa fa-file-pdf-o"></i>
                                File
                            </th>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr id="row<?= $invoice['invoice_id'] ?>">

                                <td>
                                    <?= $invoice['invoice_id'] ?>
                                </td>
                                <td>
                                    <?php

                                    $invoice_model = Invoice::findOne($invoice['invoice_id']);
                                    $operation = $invoice_model->getOperation();
                                    if ($operation):


                                        ?>

                                        <a class="btn " target="_blank"
                                           href="<?= Url::toRoute('operations/view/' . $operation->operation_id) ?>"
                                           target="_blank"><?= $operation->reference_id . ': ' . $operation->dischargingShip->name . ' - ' . $operation->receivingShip->name ?></a>
                                    <?php else: ?>
                                        <span class="label label-danger label-sm"> Not Assigned </span>
                                    <?php endif; ?>
                                </td>

                                <td> <?= $invoice['date'] ?> </td>
                                <td> <?= $invoice['total'] ?> </td>
                                <td> <?= $invoice['less'] ?> </td>
                                <td> <?= $invoice['net_amount'] ?> </td>
                                <td>
                                    <span class="label label-<?= $invoice['status'] == 'pending' ? 'warning' : ($invoice['status'] == 'payed' ? 'success' : 'danger') ?> label-sm"> <?= $invoice['status'] ?> </span>
                                </td>
                                <td>
                                    <?php if ($invoice['file']): ?>

                                        <a class="btn btn-sm blue btn-outline"
                                           href="<?= Yii::$app->request->baseUrl . '/' . $invoice['file'] ?>"
                                           target="_blank">View Document</a>
                                    <?php else: ?>
                                        <span class="label label-danger label-sm"> Not Ready </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-sm grey-salsa btn-outline"
                                           href="<?= Url::toRoute('invoices/view/' . $invoice['invoice_id']) ?>"
                                           target="_blank">View Details</a>

                                        <a class="btn btn-circle btn-icon-only default"
                                           href="<?= Url::toRoute('invoices/update/' . $invoice['invoice_id']) ?>">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top"
                                               title="Edit"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:;"
                                           data-original-title="Are you sure you want to delete invoice permanently?"
                                           data-id="<?= $invoice['invoice_id'] ?>" data-message="Invoice deleted."
                                           data-errormessage="An error ocurred while tryng to delete invoice and its details."
                                           data-url="<?= Url::toRoute("invoices/delete") ?>" data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete invoice"></i>
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

                    $.post(url, {"invoice_id": id},
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
            update();
            return false;
        });

    });


    function ex() {
        var csv = $('#dataTableUsers').table2CSV({delivery: 'value'});
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        return csvData;
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
                        document.location = '<?=Url::toRoute("invoices/")?>';
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
                'download': 'Invoices.csv',
                'href': ex(),
                'target': '_blank'
            });
    });
</script>
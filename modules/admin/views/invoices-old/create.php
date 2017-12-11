<?php
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>


<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?= $model->isNewrecord ? 'Create Invoice' : 'Update Invoice Details' ?>
    <small> operation invoice</small>
</h3>
<?php if ($model->isNewRecord) {
    $action = 'invoices/create/';
} else {
    $action = 'invoices/update/' . $model->invoice_id;
}
//die(var_dump($action));
?>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => [$action],
    'options' => ["enctype" => "multipart/form-data", 'id' => 'invoice_form']

]);

?>

<?php


if ($assigned_operation) {
    $operation = $assigned_operation;
} else {
    $operation = $model->getOperation();
}

// die(var_dump($operation));


if ($operation):
    ?>
    <div id="operation_details_main">
        <div class="row">
            <div class="col-md-5">
                <h3>Client:</h3>
                <ul class="list-unstyled">
                    <?php $client = $operation->user; ?>
                    <li> <?= $client->first_name . ' ' . $client->last_name ?> </li>
                    <li><a href="mailto: <?= $client->email ?>"><?= $client->email ?></a></li>
                    <li><a href="tel: <?= $client->email ?>"><?= $client->phone ?></a></li>

                </ul>
            </div>
            <div class="col-md-5 invoice-payment">
                <h3>Operation Details:</h3>
                <ul class="list-unstyled">
                    <?php $operation = $model->operation; ?>
                    <li>
                        <strong>Reference ID:</strong>
                        <span class="pull-right text-left">#<?= $operation->reference_id ?> </span>
                    </li>
                    <li>
                        <strong>Discharging/Receiving vessels:</strong>
                        <span class="pull-right">
                            <?= $operation->dischargingShip->name ?>-<?= $operation->receivingShip->name ?> 
                        </span>
                    </li>
                    <li>
                        <strong>Location:</strong>
                        <span class="pull-right"><?= $operation->location->title ?> </span>
                    </li>
                    <li>
                        <strong>End Time:</strong>
                        <span class="pull-right">
                            <?= date('d M Y', strtotime($operation->end_time)) ?> 
                        </span>
                    </li>
                    <?php if ($operation->report): ?>
                        <li class="hide-print">
                            <strong>Post Operation Report:</strong>
                            <span class="pull-right">
                            <a href="<?= Yii::$app->request->baseUrl . '/' . $operation->report->file ?>"
                               target="_blank" class="btn btn-sm blue btn-outline">View Document</a>
                        </span>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>


        </div>
    </div>


<?php else: ?>
    <div class="alert alert-danger hide-print alert-dismissible fade in alert-operation" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <b> Operation not assigned! </b>

    </div>

    <div id="operation_details_main"></div>

<?php endif; ?>
<input type="hidden" id="operation_id_input" name="Invoice[operation_id]"
       value="<?= $operation ? $operation->operation_id : '' ?>"/>
<?php if (!$model->isNewRecord): ?>
    <a class=" btn btn-success btn-sm" href="<?= Url::toRoute('invoices/view/' . $model->invoice_id) ?>"
       target="_blank">
        <i class="fa fa-eye"></i> View Invoice Details
    </a>
<?php endif; ?>

<button type="button" class="btn green" data-target="#modal_operation_1" data-toggle="modal">
    <?php if (!$operation): ?>
        Assign Operation
    <?php else: ?>
        Change Operation
    <?php endif; ?>
</button>

<button type="submit" class="btn green submit-btn"> Submit
    <i class="fa fa-check"></i>
</button>
<div class="clearfix"></div>

<style>
    .modal.large, .modal.large .modal-dialog {
        width: 80%;
        margin: 0 auto;
    }
</style>

<div id="modal_operation_1" class="modal fade large" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Assign Operation</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="control-label col-md-4">Operation</label>
                    <div class="col-md-8">
                        <select class="form-control select2" name="Invoice['operation_id']" id="operation-select">
                            <option></option>
                            <optgroup label="Operations without invoice assigned">
                                <?php foreach ($operations as $operation): ?>
                                    <?php if (!$operation->invoice_id): ?>
                                        <option value="<?= $operation->operation_id ?>">
                                            <?= $operation->reference_id . ": " . $operation->dischargingShip->name . ' - ' . $operation->receivingShip->name ?>
                                        </option>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Change Invoice for operation">
                                <?php foreach ($operations as $operation): ?>
                                    <?php if ($operation->invoice_id): ?>
                                        <option value="<?= $operation->operation_id ?>">
                                            <?= $operation->reference_id . ": " . $operation->dischargingShip->name . ' - ' . $operation->receivingShip->name ?>
                                        </option>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>

                        </select>
                    </div>
                </div>
                <div id="operation_details">


                </div>

            </div>
            <div class="modal-footer">
                <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true" onclick="modalCancel()">
                    Close
                </button>
                <button class="btn green" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!--<form action="<?= Url::toRoute('invoices/create/') ?>" enctype="multipart/form-data" class="form-horizontal" id="invoice_form" method="POST">
       -->
<div class="row">
    <div class="tab-content col-md-5">
        <div class="alert alert-danger display-none">
            <button class="close" data-dismiss="alert"></button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success display-none">
            <button class="close" data-dismiss="alert"></button>
            Your form validation is successful!
        </div>


        <div class="update-pane">

            <div class="hide-print">


            </div>


            <h3 class="block ">Invoice details</h3>


            <div class="clearfix"></div>

            <div class="form-group">
                <label class="col-md-4 control-label"> Total
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-dollar"></i>
                        </span>
                        <input type="number" id="total" name="Invoice[total]" class="form-control"
                               value="<?= $model->total ?>"/></div>
                    <p class="help-block"> Enter total amount </p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label"> Less
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-dollar"></i>
                        </span>
                        <input type="number" id="less" name="Invoice[less]" class="form-control"
                               value="<?= $model->less ?>"/></div>
                    <p class="help-block"> Enter less amount</p>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label"> Net Amount
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-dollar"></i>
                        </span>
                        <input type="number" id="less" name="Invoice[net_amount]" class="form-control"
                               value="<?= $model->net_amount ?>"/></div>
                    <p class="help-block"> Enter net amount</p>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>


        <!-- PDF -->
        <div class="update-pane">
            <h3 class="block">Add Invoice Document</h3>

            <div class="form-group">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                        <?php if (!$model->file): ?>
                            <span class="label label-danger">No file</span>
                        <?php else: ?>
                        <embed src="<?= Url::home(true) ?>/<?= $model->file ?>" type='application/pdf'>
                            <?php endif; ?>
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"
                         style="max-width: 200px; max-height: 150px;"></div>

                    <div>
                            <span class="btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <?= $form->field($model, 'file')->fileInput()->label(false) ?> </span>
                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
                            Remove </a>
                    </div>
                </div>

            </div>


        </div>


    </div>
    <div class="col-md-7">

        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">

                    <i class="icon-flag font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Invoice Items</span>

                </div>
                <div class="hide-print pull-right">
                    <a data-toggle="modal" data-target="#myModal2" class=" btn red btn-sm"><i class="fa fa-plus"></i>
                        Add invoice item</a>
                </div>

            </div>
            <div class="portlet-body">
                <!--BEGIN TABS-->
                <div class="tab-content">

                    <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                        <ul class="feeds op_stat" id="invoice-items">

                            <li>
                                <div class="row text-center">

                                    <div class="col-md-6">
                                        <b>DESCRIPTION</b>
                                    </div>
                                    <div class="col-md-1">
                                        <b>RATE PER DAY</b>
                                    </div>
                                    <div class="col-md-2">
                                        <b>DAYS NO</b>
                                    </div>
                                    <div class="col-md-2">
                                        <b>TOTAL AMOUNT</b>
                                    </div>

                                    <div class="col-md-1">

                                    </div>
                                </div>
                            </li>

                            <?php foreach ($model->invoiceItems as $item): ?>

                                <li>
                                    <div class="row text-center" id="invoice-item-<?= $item->invoice_item_id ?>">

                                        <div class="col-md-6">
                                            <?= $item->description ?>
                                        </div>
                                        <div class="col-md-1">
                                            <?= $item->rate_per_day == null ? "NA" : $item->rate_per_day ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $item->days_no == null ? "NA" : $item->days_no ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $item->amount ?>
                                        </div>

                                        <div class="col-md-1">
                                            <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                               href="javascript:;"
                                               data-original-title="Are you sure you want to delete invoice item permanently?"
                                               data-id="<?= $item->invoice_item_id ?>"
                                               data-message="Invoice item deleted."
                                               data-errormessage="An error occurred while trying to delete invoice item."
                                               data-url="<?= Url::toRoute('invoices/delete_item/' . $item->invoice_item_id) ?>"
                                               data-placement="bottom"


                                            >
                                                <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                                   title="Remove invoice item"></i>
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


    </div>
</div>

<!-- INVOICE ITEM MODAL -->

<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title modal-title"> Add Invoice Item
                    <small>invoice details</small>
                </h3>
                <!-- END PAGE TITLE-->
            </div>
            <div class="modal-body">


                <div class="portlet light bg-inverse">
                    <div class="portlet-title">
                        <div class="caption red-sunglo">
                            <span class="caption-subject font-red-sunglo bold  block pull-left"
                                  style="padding: 5px 15px 5px 0; font-size: 16px"><b>Add Invoice Item</b></span>

                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="portlet-body form">
                        <div class="form-group">
                            <div class="row" style="margin: 0">
                                <label class="control-label col-md-4">Amount
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="item-amount" step="0.1"/>
                                    <span class="help-block"> Set amount </span>

                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="margin: 0">
                                <label class="control-label col-md-4">Description
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="item-description"></textarea>
                                    <span class="help-block"> Set description </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row" style="margin: 0">
                                <label class="control-label col-md-4">Rate per day
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="item-rpd" type="number" step="0.1">
                                    <span class="help-block"> Set rate per day or leave empty </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="margin: 0">
                                <label class="control-label col-md-4">Days No
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="item-days_no" type="number" step="1">
                                    <span class="help-block"> Set days number or leave empty </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn green add-item-btn" onclick="addNewItem()"> Set</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</form>

<script>
    var $items = 0;
    var $operation = -1;

    function addNewItem() {

        $amount = $('#item-amount').val();

        $description = $('#item-description').val();

        $rate_per_day = $('#item-rpd').val();

        $days_no = $('#item-days_no').val();

        $items++;

        $html = "<li id=\"new-item" + $items + "\">";
        $html += "<div class=\"row\">";
        $html += " <div class=\"col-md-6\"><div class=\"desc\"> <textarea name=\"InvoiceItem[" + $items + "][description]\" readonly>" + $description + "</textarea></div></div>";
        $html += "       <div class=\"col-md-1\"><div class=\"date\"><input name=\"InvoiceItem[" + $items + "][rpd]\" type='number' readonly value='" + $rate_per_day + "'> </div></div>";
        $html += "       <div class=\"col-md-2\"><div class=\"date\"><input name=\"InvoiceItem[" + $items + "][days_no]\" type='number' readonly value='" + $days_no + "'> </div></div>";
        $html += "       <div class=\"col-md-2\"><input name=\"InvoiceItem[" + $items + "][amount]\" type='number' readonly value='" + $amount + "'></div>";
        $html += "        <div class=\"col-md-1\">";
        $html += "           <a class=\"btn btn-circle btn-icon-only red confirmation-delete\" href=\"javascript:;\" data-original-title=\"Are you sure you want to delete invoice item permanently?\" data-message=\"Invoice item deleted.\" data-errormessage=\"An error occurred while trying to delete invoice item.\" data-el_id=\"#new-item" + $items + "\" data-placement=\"bottom\" >";
        $html += "                <i class=\"icon-trash\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Remove invoice item\"></i>";
        $html += "            </a>";
        $html += "        </div>";
        $html += "    </div>";

        $html += "</li>";


        $("#invoice-items").append($html);


        $('#item-amount').val('');
        $('#item-description').val('');
        $('#item-rpd').val('');
        $('#item-days_no').val('');

        $('#myModal2').modal('hide');


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
                var el_id = $(this)[0].el_id;

                if (el_id) {
                    toastr.success(message);
                    return removeItem(el_id);
                }

                $.post(url, {},
                    function (data) {


                        if (data.result == "success" && data.status == 200) {
                            $('#invoice-item-' + id).fadeOut();
                            $('#invoice-item-' + id).remove();
                            toastr.success(message);

                        } else {
                            toastr.error(data.data.error_description);
                        }

                    }, 'json'
                );
            }
        });

        return false;

    }

    function removeItem($id) {
        $($id).remove();
    }

    function modalCancel() {
        $operation = -1;

        return true;
    }

    $(document).ready(function () {

        $("#modal_operation_1").on('shown.bs.modal', function () {
            $operation = -1;
            $('#operation_details').html('');
            $("select#operation-select").val('-1');

        });

        $("#modal_operation_1").on('hidden.bs.modal', function () {

            $el = $('#operation_details_main');

            if ($operation != -1) {
                $el.html($('#operation_details').html());
                $('#operation_id_input').val($operation);
                $('.alert-operation').hide();
            }

            $('#operation_details').html('');
            $("select#operation-select").val('-1');

        });


        $("select#operation-select").on("change", function () {
            var $this = $(this);
            $operation = $this.val();

            $.post("<?=Url::toRoute('invoices/operation_details/')?>/" + $this.val(), {}, function (data) {

                if (data.result == 'success') {

                    console.log(data);

                    data = data.data;

                    $el = $('#operation_details');
                    $el.html('');

                    var html = '<div class="row">';
                    html += '<div class="col-md-5">';
                    html += '<h3>Client:</h3>';
                    html += '<ul class="list-unstyled">';

                    html += '<li> ' + data.user.first_name + ' ' + data.user.last_name + ' </li>';
                    html += '<li> <a href="mailto: ' + data.user.email + '">' + data.user.email + '</a> </li>';
                    html += '<li> <a href="tel: ' + data.user.phone + '">' + data.user.phone + '</a></li>';

                    html += '</ul>';
                    html += '</div>';
                    html += '<div class="col-md-5 invoice-payment">';
                    html += '<h3>Operation Details:</h3>';
                    html += '<ul class="list-unstyled">';

                    html += '<li>';
                    html += ' <strong>Reference ID:</strong> ';
                    html += ' <span class="pull-right text-left">#' + data.reference_id + ' </span>';
                    html += '</li>';
                    html += '<li>';
                    html += '  <strong>Discharging/Receiving vessels:</strong> ';
                    html += ' <span class="pull-right">';
                    html += data.receiving_ship.name + ' - ' + data.discharging_ship.name;
                    html += ' </span>';
                    html += ' </li>';
                    html += '<li>';
                    html += ' <strong>Location:</strong> ';
                    html += ' <span class="pull-right">' + data.location.title + ' </span>';
                    html += '</li>';
                    html += '<li>';
                    html += '<strong>End Time:</strong> ';
                    html += '<span class="pull-right">' + data.end_time + '</span>';

                    html += '</li>';
                    if (data.report) {
                        html += '<li class="hide-print">';
                        html += '<strong>Post Operation Report:</strong>';
                        html += '<span class="pull-right">';
                        html += ' <a href="<?=Yii::$app->request->baseUrl?>' + '/' + data.report.file + '" target="_blank" class="btn btn-sm blue btn-outline">View Report</a>';
                        html += '</span>';
                        html += '</li>';
                    }

                    html += '</ul>';
                    html += ' </div>';


                    html += '</div>';

                    $el.html(html);
                } else {
                    toastr.error('An error occurred whle trying to fetch operation details.')
                }

            });

            //alert($this.val());
        });

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

                $.post(url, {},
                    function (data) {


                        if (data.result == "success" && data.status == 200) {
                            $('#invoice-item-' + id).fadeOut();
                            $('#invoice-item-' + id).remove();
                            toastr.success(message);

                        } else {
                            toastr.error(data.data.error_description);
                        }

                    }, 'json'
                );
            }
        });

    });

</script>   

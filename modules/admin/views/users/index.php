<?php

use yii\helpers\Html;
use yii\helpers\Url;

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];

?>
<style>

    .popover {
        z-index: 10050 !important;
    }
</style>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Users
    <small>users & statistics</small>
</h3>
<!-- END PAGE TITLE-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Users</b></span>

                <div class="pull-left hide-print">
                    <a href="<?= Url::toRoute('users/create') ?>" class=" btn red btn-sm"><i class="fa fa-plus"></i> Add
                        New User</a>
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
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="form-group">
                    <h2 style="display: inline-block">Bulk operations</h2>
                    <?= Html::a('Choose an option', false, ['class' => 'btn btn-success', 'style' => "display: inline-block; margin: -5px 0 0 20px;", 'data' => ['toggle' => 'modal', 'target' => '#bulkModal']]) ?>

                </div>
                <div class="form-group">
                    <br>
                    <?= Html::a('Select All', false, ['class' => 'btn btn-danger', 'style' => "display: inline", 'id' => 'select-all']) ?>
                </div>


                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover table-advance" id="dataTableUsers">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="select-on-check-all" name="id_all" value="1"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data["users"] as $user): ?>
                            <tr class="odd" id="row<?= $user->user_id ?>">
                                <td><input type="checkbox" name="id[]" value="<?= $user->user_id ?>"/></td>
                                <td><?= $user->first_name . ' ' . $user->last_name ?></td>
                                <td><?= $user->email ?></td>
                                <td><span class="<?= $role_colors[$user->role] ?>"><?= $user->role ?></span></td>
                                <td><?= $user->phone ?></td>

                                <td class="hide-print">
                                    <div class="actions">

                                        <a class="btn btn-circle btn-icon-only green"
                                           href="<?= Url::toRoute('users/view/' . $user->user_id) ?>">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top"
                                               title="Manage User Account"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:"
                                           data-original-title="Are you sure you want to delete user permanently?"
                                           data-id="<?= $user->user_id ?>" data-message="User deleted."
                                           data-errormessage="An error ocurred while tryng to delete user account."
                                           data-url="<?= Url::toRoute("users/delete/" . $user->user_id) ?>"
                                           data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete user"></i>
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
<div id="bulkModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bulk options</h4>
            </div>
            <div class="modal-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Market Report Access Settings <i class="fa fa-angle-down"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="form-group">
                                    <input type="checkbox" class="make-switch" checked data-on="success"
                                           data-on-color="success" data-off-color="default" data-size="big"
                                           id="marketReportsSetting">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger" id="marketReportsSave"
                                            data-url="<?= Url::toRoute("users/market_reports") ?>">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Send Push notification <i class="fa fa-angle-down"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="form-group">
                                    <textarea id="pushMessage" placeholder="Enter message text ..." rows=6
                                              style="min-width: 100%"></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-success" id="sendPush"
                                            data-url="<?= Url::toRoute("users/send_push") ?>">Send
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Delete <i class="fa fa-angle-down"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingThree">
                            <div class="panel-body">
                                <?= Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete selected records"></i> Delete Selected', 'javascript:;', [
                                    'title' => Yii::t('yii', 'Delete Selected'), 'class' => 'btn  red confirmation-delete-selected',
                                    'data' => [
                                        'original-title' => 'Are you sure you want to delete selected records permanently?',
                                        'message' => 'Records deleted',
                                        'errormessage' => 'An error ocurred while trying to delete records.',
                                        'url' => Url::toRoute("users/delete_selected"),
                                        'placement' => 'bottom'


                                    ]
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        toastr.options.closeDuration = 50;
        Main.init();
        Main.initDatatable('#dataTableUsers');

        Main.initExport(".export", "UserOngoingOperations", function () {

            var csv = $('#dataTableUsers').table2CSV({delivery: 'value'});
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
            return csvData;

        });

        Main.initConfirmation('.confirmation-delete');

        $('.confirmation-delete-selected').confirmation({
            container: 'body',
            btnOkClass: 'btn btn-sm btn-success',
            btnOkLabel: 'Delete ',
            btnCancelClass: 'btn btn-sm btn-danger',

            onConfirm: function () {

                var id = $(this)[0].id;
                var prefix = $(this)[0].idprefix;
                var url = $(this)[0].url;
                var message = $(this)[0].message;
                var error_message = $(this)[0].errormessage;
                var keys = [];

                $('#dataTableUsers ').find("input[name=id\\[\\]]:checked").each(function () {
                    keys.push($(this).val());
                });


                $.post(url, {ids: keys},
                    function (data) {
                        if (data.result == 'success') {
                            toastr.success(message);
                            setTimeout(function () {
                                location.reload()
                            }, 3000);
                        } else {
                            toastr.error(data.message + ' ' + data.data.error_description);
                        }

                    }, 'json'
                );
            }
        });

        $("input[name=id_all], #select-all").click(function () {
            var checkBoxes = $("input[name=id\\[\\]]");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            checkBoxes.parent().toggleClass('checked');
            $('#select-all').text($('#select-all').text() == "Select All" ? "Unselect All" : "Select All");

        });

        $("#sendPush").click(function () {
            var url = $(this).data('url');
            var message = $("#pushMessage").val();
            var keys = [];

            $('#dataTableUsers ').find("input[name=id\\[\\]]:checked").each(function () {
                keys.push($(this).val());
            });

            console.log(keys);

            $.post(url, {"message": message, "users": keys}, function (data) {
                if (data.result == 'success') {
                    toastr.success('Push notification successfully sent.');
                    $("#bulkModal").modal('close');
                } else {
                    toastr.error(data.data);
                }
            });

        });
        $("#marketReportsSetting").bootstrapSwitch();

        $("#marketReportsSave").click(function () {
            var url = $(this).data('url');
            var setting = $("#marketReportsSetting").is(":checked") ? 1 : 0;
            var keys = [];

            $('#dataTableUsers ').find("input[name=id\\[\\]]:checked").each(function () {
                keys.push($(this).val());
            });

            $.post(url, {"setting": setting, "users": keys}, function (data) {
                if (data.result == 'success') {
                    toastr.success('Access successfully changed.');
                    $("#bulkModal").modal('close');
                } else {
                    toastr.error(data.data);
                }
            });

        });


    });

</script>

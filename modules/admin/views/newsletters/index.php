<?php

use app\models\Newsletter;
use yii\helpers\Url;

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];
$model = new Newsletter;

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Newsletters
    <small>newsletters & statistics</small>
</h3>
<!-- END PAGE TITLE-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Newsletters</b></span>
                <!-- treba da se otvori forma -->
                <div class="pull-left hide-print">
                    <a class="accordion-toggle collapsed btn red btn-sm" data-toggle="collapse"
                       data-parent="#accordion1" href="#accordion_create" aria-expanded="false">
                        <i class="fa fa-plus"></i> Add New Newsletter</a>
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

            <!-- CREATE NEWSLETTER MODAL -->


            <div id="accordion_create" class="panel-collapse collapse" aria-expanded="false">

                <?= $this->render('newsletter-form', ['model' => $model]); ?>
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
                            <th>Title</th>
                            <th>Date</th>
                            <th>File</th>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data["newsletters"] as $newsletter): ?>
                            <tr class="odd" id="row<?= $newsletter['newsletter_id'] ?>">
                                <td><?= $newsletter['title'] ?></td>
                                <td>
                                    <span class="date"><?= $newsletter['date'] ?></span>
                                </td>
                                <td>

                                    <a class="btn btn-sm blue btn-outline"
                                       href="<?= Yii::$app->request->baseUrl . '/' . $newsletter['file'] ?>"
                                       target="_blank">View PDF</a>

                                </td>

                                <td class="hide-print">
                                    <div class="actions">

                                        <a class="btn btn-circle btn-icon-only green"
                                           onClick="openEditModal('<?= $newsletter['title'] ?>', '<?= Url::toRoute('newsletters/update/' . $newsletter['newsletter_id']) ?>', '<?= Url::home(true) ?>/<?= $newsletter['file'] ?>')">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Edit Newsletter Details"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:;"
                                           data-original-title="Are you sure you want to delete newsletter permanently?"
                                           data-id="<?= $newsletter['newsletter_id'] ?>"
                                           data-message="Newsletter deleted."
                                           data-errormessage="An error ocurred while tryng to delete newsletter."
                                           data-url="<?= Url::toRoute("newsletters/delete") ?>" data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete newsletter"></i>
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
                <h4 class="modal-title">Edit Newsletter Details</h4>
            </div>
            <div class="modal-body">

                <form class="form margin-bottom-40" role="form" action="" method="post" enctype="multipart/form-data"
                      id="edit-form">
                    <div class="form-group form-md-line-input has-success">
                        <input type="text" class="form-control" id="edit-name-field" name="Newsletter[title]">
                        <div class="form-control-focus"></div>
                        <label> Title </label>
                    </div>
                    <div class="form-group">
                        <label> File </label>

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">

                                <embed src="" type='application/pdf' id="modal-embed-file">

                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"
                                 style="max-width: 200px; max-height: 150px;"></div>


                            <span class="btn default btn-file">
                    <span class="fileinput-new"> Select file </span>
                    <span class="fileinput-exists"> Change </span>
                   <input type="file" name="Newsletter[file]"/>
                 </span>
                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
                                Remove </a>
                        </div>

                    </div>

                    <button type="button" class="btn btn-danger" onClick="updateNewsletter()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>

            </div>

        </div>

    </div>
</div>

<script>


    $(document).ready(function () {

        toastr.options.closeDuration = 50;

        Main.initConfirmation('.confirmation-delete');

        Main.initExport(".export", 'Newsletters', ex);
        Main.initDatatable('#dataTableUsers');


        $('#edit-form').submit(function () {
            updateShip();
            return false;
        });

    });

    function saveNewsletter() {

        $form = $('#newNewsletterForm');
        $url = $form.attr('action');

        $data = new FormData(document.getElementById("newNewsletterForm"));
        console.log($data);

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
                    toastr.error('An error occurred while trying to save newsletter details.');
                    return false;
                },
                200: function (data) {
                    if (data.result == "success" && data.status == 200) {
                        toastr.success('Newsletter successfully created. ');
                        setTimeout(function () {
                            document.location = '<?=Url::toRoute("newsletters/")?>';
                        }, 2000);
                    } else {
                        toastr.error(data.data.error_description);

                    }

                    return false;
                },
            },
        });
    }


    function openEditModal($name, $action, $file) {
        $("#edit-name-field").val($name)
        $("#modal-embed-file").attr('src', $file)
        $("#edit-form").attr('action', $action)
        $("#edit-modal").modal("show");
    }

    function updateNewsletter() {


        $form = $('#edit-form');
        $url = $form.attr('action');

        $data = new FormData(document.getElementById("edit-form"));
        console.log($data);

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
                    toastr.error('An error occurred while trying to save newsletter details.');
                    return false;
                },
                200: function (data) {
                    if (data.result == "success" && data.status == 200) {
                        toastr.success('Newsletter successfully updated. ');
                        setTimeout(function () {
                            document.location = '<?=Url::toRoute("newsletters/")?>';
                        }, 2000);
                    } else {
                        toastr.error(data.data.error_description);

                    }

                    return false;
                },
            },
        });

    }


</script>
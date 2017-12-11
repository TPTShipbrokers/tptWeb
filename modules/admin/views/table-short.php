<?php

$role_colors = $this->context->module->params["role_colors"];
$status_colors = $this->context->module->params["status_colors"];

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?= $title ?>
    <small><?= $title ?> & statistics</small>
</h3>
<!-- END PAGE TITLE-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="caption-subject font-red-sunglo bold uppercase block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b><?= $title ?></b></span>
                <!-- treba da se otvori forma -->
                <div class="pull-left hide-print">
                    <a class="accordion-toggle collapsed btn red btn-sm" data-toggle="collapse"
                       data-parent="#accordion1" href="#accordion_create" aria-expanded="false">
                        <i class="fa fa-plus"></i> Add New </a>
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
                    <?= $this->render('/' . $info['controller_id'] . '/create-form', ['model' => new $info['model'], 'create_url' => $info['create_url']]) ?>

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
                            <?php foreach ($attributes as $label => $attr): ?>
                                <th><?= $label ?></th>
                            <?php endforeach; ?>
                            <th class="hide-print"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr class="odd" id="row<?= $row[$info['primary_key']] ?>">
                                <?php
                                foreach ($attributes as $label => $attr):
                                    if (!is_array($attr)):
                                        ?>
                                        <td><?= $row[$attr] ?></td>
                                    <?php else: ?>
                                        <?= $this->render($attr['template'], ['model' => $row]) ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>


                                <td class="hide-print">
                                    <div class="actions">
                                        <?php
                                        if (!isset($row['profile_picture']))
                                            $onclick = 'openEditModal(\'' . $row[$edit_field] . '\',\'' . $row['update_url'] . '\')';
                                        else
                                            $onclick = 'openEditModal(\'' . $row[$edit_field] . '\',\'' . $row['update_url'] . '\',\'' . $row['profile_picture'] . '\')';
                                        ?>
                                        <a class="btn btn-circle btn-icon-only green" onClick="<?= $onclick; ?>">
                                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Edit Details"></i>
                                        </a>

                                        <a class="btn btn-circle btn-icon-only red confirmation-delete"
                                           href="javascript:"
                                           data-original-title="Are you sure you want to delete record permanently?"
                                           data-message="Record deleted."
                                           data-errormessage="An error ocurred while trying to delete record."
                                           data-url="<?= $row['delete_url'] ?>"
                                           data-id="<?= $row[$info['primary_key']] ?>" data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete"></i>
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



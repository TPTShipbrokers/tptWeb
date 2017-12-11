<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * @var \app\models\Chartering[] $ongoing_chartering
 * @var \app\models\Chartering[] $past_chartering
 * @var array $charterings
 * @var \app\models\AppUser $model
 * @var \yii\web\View $this
 */
?>

<?php
$role_colors = $this->context->module->params["role_colors"];
$field_template = [
    'options' => ['class' => 'form-group form-md-line-input'],
    'template' => '{input}{hint}{error}{label}',
    'inputOptions' => ['class' => 'form-control']
];
?>
<style>
    .form-horizontal .form-group {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> User Details
    <small>view & manage</small>
</h3>
<!-- END PAGE TITLE-->
<div class="profile">
    <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> Overview </a>
            </li>
            <li>
                <a href="#tab_1_3" data-toggle="tab"> Edit Account </a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1_1">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-unstyled profile-nav">
                            <li>
                                <?php if ($model->profile_picture): ?>
                                    <img src="<?= Yii::$app->request->baseUrl . '/' . $model->profile_picture ?>"
                                         class="img-responsive pic-bordered" alt=""/>
                                <?php else: ?>
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                         style="width: 100%" class="img-responsive pic-bordered" alt=""/>
                                <?php endif; ?>

                            </li>

                            <?php if ($model->role == 'client'): ?>
                                <li class=" hide-print">
                                    <a href="javascript:" class="btn btn-success text-left" data-toggle="modal"
                                       data-target="#assignCharteringModal" style="text-align: left"> Assign the
                                        chartering </a>
                                </li>
                                <li class=" hide-print">
                                    <a href="javascript:" class="btn btn-success text-left" data-toggle="modal"
                                       data-target="#assignCompanyModal" style="text-align: left"> Assign company </a>
                                </li>
                            <?php endif; ?>
                            <li class=" hide-print">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1"
                                   href="#accordion_settings"> Settings </a>
                                <div id="accordion_settings" class="panel-collapse collapse ">
                                    <div class="panel-body">
                                        <a class="btn red confirmation-delete" href="javascript:"
                                           data-original-title="Are you sure you want to delete user permanently?"
                                           data-id="<?= $model->user_id ?>" data-message="User deleted."
                                           data-errormessage="An error occurred while trying to delete user account."
                                           data-url="<?= Url::toRoute('users/delete/' . $model->user_id) ?>"
                                           data-placement="bottom">
                                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                               title="Delete user"></i> Delete User
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-8 profile-info">
                                <h1 class="font-green sbold uppercase"><?= $model->first_name . " " . $model->last_name ?></h1>

                                <p>

                                </p>
                                <ul class="list" style="list-style:none">
                                    <li>
                                        <i class="fa fa-envelope"></i> <a
                                                href="mailto:<?= $model->email ?>"> <?= $model->email ?> </a>
                                    </li>
                                    <?php if ($model->role == 'team'): ?>
                                        <li>
                                            <i class="fa fa-envelope"></i> <a
                                                    href="mailto:<?= $model->email2 ?>"> <?= $model->email2 ?> </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <i class="fa fa-phone"></i> <?= $model->phone ?>
                                    </li>
                                    <?php if ($model->role == 'team'): ?>
                                        <li>
                                            <i class="fa fa-phone"></i> <?= $model->phone2 ?>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($model->role == 'client' && $model->company): ?>
                                        <li>
                                            <i class="fa fa-building-o"></i> <?= $model->company->company_name ?>
                                        </li>
                                    <?php endif; ?>


                                    <li>
                                        <i class="fa fa-user"></i> <span class="label label-warning"
                                                                         style="display: inline-block"><?= $model->role ?> </span>
                                    </li>
                                    <?php if ($model->role == 'client'): ?>
                                        <li>
                                            <i class="fa fa-file-pdf-o"></i> Market Reports Access:
                                            <span class="label label-<?= $model->market_report_access_level == 1 ? 'success' : 'danger' ?>"><?= $model->market_report_access_level == 1 ? "On" : "Off" ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="hide-print">
                                        <i class="fa fa-print"></i> <a href="#" class="btn btn-success btn-sm"
                                                                       onclick="windowPrint(); return false;">Print</a>
                                    </li>

                                </ul>
                            </div>
                            <!--end col-md-8-->
                            <div class="col-md-4">
                                <div class="portlet sale-summary">
                                    <div class="portlet-title">
                                        <div class="caption font-red sbold"> Summary</div>
                                        <div class="tools">
                                            <a class="reload" href="javascript:"> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="sale-info"> ONGOING CHARTERING
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num"> <?= count($ongoing_chartering) ?> </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> PAST CHARTERING
                                                    <i class="fa fa-img-down"></i>
                                                </span>
                                                <span class="sale-num"> <?= count($past_chartering) ?> </span>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end col-md-4-->
                        </div>
                        <!--end row-->
                        <div class="tabbable-line tabbable-custom-profile">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_11" data-toggle="tab">
                                        Ongoing Chartering
                                        <span class="badge badge-default"><?= count($ongoing_chartering) ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_1_22" data-toggle="tab">
                                        Past Chartering
                                        <span class="badge badge-default"><?= count($past_chartering) ?></span>
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_11">
                                    <div class="portlet-body">
                                        <?php if (!empty($ongoing_chartering)): ?>
                                            <div class="pull-left hide-print" style="margin-bottom: 10px">
                                                <a href="#" class="export-ongoing btn btn-success btn-sm"><i
                                                            class="fa fa-bars"></i> Export Table Data into CSV</a>

                                            </div>
                                        <?php endif; ?>
                                        <div class="clearfix"></div>
                                        <?php if (!empty($ongoing_chartering)): ?>
                                            <table id="ongoingOperationsTable"
                                                   class="table table-striped table-bordered table-advance table-hover">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <i class="fa fa-briefcase"></i> ID
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-briefcase"></i> Permission status
                                                    </th>
                                                    <th></th>
                                                    <th>
                                                        <i class="fa fa-flag"></i> Status
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-bookmark"></i> Update time
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-ship"></i>
                                                        Ship documentation
                                                    </th>

                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($ongoing_chartering as $chartering): ?>
                                                    <tr>
                                                        <td><?= $chartering->chartering_id ?></td>
                                                        <td>
                                                        <span class="label label-info">
                                                        <?= $chartering->getCharteringClients()->where(['client_id' => $model->user_id])->one()->status ?>
                                                        </span>
                                                        </td>
                                                        <td> <?= $chartering->vessel_name ?> </td>
                                                        <td>
                                                            <?= $chartering->status ? $chartering->status->status->description : "" ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo $chartering->status ? date('d M, Y', strtotime($chartering->status->datetime)) : "";
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($chartering->ship_documentation): ?>
                                                            <a class="btn btn-sm blue btn-outline"
                                                               href="<?= Yii::$app->request->baseUrl . '/' . $chartering->ship_documentation ?>"
                                                               target="_blank">View ship documentation</a>
                                                        <?php else: ?>
                                                            <span class="label label-danger label-sm"> Not Ready </span>
                                                        <?php endif; ?>

                                                        </td>

                                                        <td>
                                                            <a class="btn btn-sm grey-salsa btn-outline"
                                                               href="<?= Url::toRoute('chartering/view/' . $chartering->chartering_id) ?>"
                                                               target="_blank"> View more</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>


                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p> This user doesnt have any ongoing chartering </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_1_22">
                                    <div class="portlet-body">
                                        <?php if (!empty($past_chartering)): ?>
                                            <div class="pull-left hide-print" style="margin-bottom: 10px">
                                                <a href="#" class="export-past btn btn-success btn-sm"><i
                                                            class="fa fa-bars"></i> Export Table Data into CSV</a>

                                            </div>
                                        <?php endif; ?>
                                        <div class="clearfix"></div>
                                        <?php if (!empty($past_chartering)): ?>
                                            <table id="pastOperationsTable"
                                                   class="table table-striped table-bordered table-advance table-hover">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <i class="fa fa-briefcase"></i> ID
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-briefcase"></i> Permission status
                                                    </th>
                                                    <th></th>
                                                    <th>
                                                        <i class="fa fa-flag"></i>
                                                        Status
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-bookmark"></i>
                                                        Update time
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-ship"></i>
                                                        Ship documentation
                                                    </th>

                                                    <th>
                                                        <i class="fa fa-glass"></i>
                                                        Charter party
                                                    </th>

                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($past_chartering as $chartering): ?>
                                                    <tr>
                                                        <td><?= $chartering->chartering_id ?></td>
                                                        <td>
                                                        <span class="label label-info">
                                                            <?= $chartering->getCharteringClients()->where(['client_id' => $model->user_id])->one()->status ?>
                                                        </span>
                                                        </td>
                                                        <td> <?= $chartering->vessel_name ?> </td>
                                                        <td>
                                                            <?= $chartering->status->status->description ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo date('d M, Y', strtotime($chartering->status->datetime));
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($chartering->ship_documentation): ?>
                                                            <a class="btn btn-sm blue btn-outline"
                                                               href="<?= Yii::$app->request->baseUrl . '/' . $chartering->ship_documentation ?>"
                                                               target="_blank">View ship documentation</a>
                                                        <?php else: ?>
                                                            <span class="label label-danger label-sm"> Not Ready </span>
                                                        <?php endif; ?>

                                                        </td>

                                                        <td>
                                                            <?php
                                                            if ($chartering->charter_party): ?>
                                                                <a class="btn btn-sm grey-salsa btn-outline"
                                                                   href="<?= Url::toRoute('charter_party/view/' . $chartering->charter_party) ?>"
                                                                   target="_blank"> View CP details</a>
                                                            <?php else: ?>
                                                                <span class="label label-danger label-sm"> Not Ready </span>
                                                            <?php endif; ?>

                                                        </td>

                                                        <td>
                                                            <a class="btn btn-sm grey-salsa btn-outline"
                                                               href="<?= Url::toRoute('chartering/view/' . $chartering->chartering_id) ?>"
                                                               target="_blank"> View more</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p> This user doesnt have any past chartering </p>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <!--tab-pane-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--tab_1_2-->
            <div class="tab-pane" id="tab_1_3">
                <div class="row profile-account">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab" href="#tab_1-1">
                                    <i class="fa fa-cog"></i> Personal info </a>
                                <span class="after"> </span>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_2-2">
                                    <i class="fa fa-picture-o"></i> Change Profile Picture </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_3-3">
                                    <i class="fa fa-lock"></i> Change Password </a>
                            </li>
                            <li>
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1"
                                   href="#accordion_settings2">
                                    <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                                       title="Delete user"></i> Delete Accoount
                                </a>
                                <div id="accordion_settings2" class="panel-collapse collapse ">
                                    <div class="panel-body">
                                        <a class="btn red confirmation-delete" href="javascript:"
                                           data-original-title="Are you sure you want to delete user permanently?"
                                           data-id="<?= $model->user_id ?>" data-message="User deleted."
                                           data-errormessage="An error occurred while trying to delete user account."
                                           data-url="<?= Url::toRoute('users/delete/' . $model->user_id) ?>"
                                           data-placement="bottom">
                                            Delete
                                        </a>

                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div id="tab_1-1" class="tab-pane active">
                                <?php $form = ActiveForm::begin([
                                    'method' => 'post',
                                    'action' => ['users/update/' . $model->user_id],
                                    'options' => ["enctype" => "multipart/form-data", 'id' => 'update-form-1']

                                ]); ?>

                                <?= $form->field($model, 'first_name', $field_template)
                                    ->textInput(['required' => true])
                                    ->label('First Name')
                                    ->hint('User first name.')
                                ?>
                                <?= $form->field($model, 'last_name', $field_template)
                                    ->textInput(['required' => true])
                                    ->label('Last Name')
                                    ->hint('User last name.')
                                ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'email',
                                            [
                                                'options' => ['class' => 'form-group form-md-line-input'],
                                                'template' => '{input}{hint}{error}{label}',
                                                'inputOptions' => ['class' => 'form-control', 'required' => true]
                                            ])
                                            ->input('email')
                                            ->label('Email')
                                            ->hint('Email address.')
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'email2',
                                            [
                                                'options' => ['class' => 'form-group form-md-line-input'],
                                                'template' => '{input}{hint}{error}{label}',
                                                'inputOptions' => ['class' => 'form-control', 'required' => false]
                                            ])
                                            ->input('email2')
                                            ->label('Email 2')
                                            ->hint('Second email address.')
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'phone', $field_template)
                                            ->textInput(['required' => false])
                                            ->label('Phone')
                                            ->hint('Users primary phone number.')
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'phone2', $field_template)
                                            ->textInput(['required' => false])
                                            ->label('Phone 2')
                                            ->hint('Users secondary phone number.')
                                        ?>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <?= $this->render('/radio-group-control',
                                    ['model' => $model, 'attribute' => 'role', 'label' => 'Role', 'name' => 'AppUser[role]', 'values' => ['Admin' => 'admin', 'Client' => 'client', 'Team' => 'team']]) ?>
                                <?php if ($model->role == 'client'): ?>
                                    <div class="form-group form-md-radios form-horizontal">
                                        <label class="control-label"> Market Reports Access </label>


                                        <?= $form->field($model, 'market_report_access_level')->checkbox([
                                            'label' => '',
                                            'labelOptions' => ['style' => 'padding:5px;'],
                                            'class' => 'make-switch', 'data' => ['on' => 'success', 'on-color' => 'success', 'off-color' => 'default', 'size' => 'big', 'id' => 'marketReportsSetting']])
                                            ->label(false);
                                        ?>
                                    </div>

                                <?php endif; ?>

                                <div class="clearfix"></div>

                                <?= $form->field($model, 'position', $field_template)
                                    ->textInput(['required' => false])
                                    ->label('Position')
                                    ->hint('User position. Relevant only for Team members. ex. Account Manager, Operations Manager, Client Services ...')
                                ?>


                                <div class="margin-top-10">
                                    <button onClick="updateBasicSubmit()" class="btn green"> Save Changes</button>
                                    <a href="<?= Url::toRoute('users/view/' . $model->user_id) ?>" class="btn default">
                                        Cancel </a>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                            <div id="tab_2-2" class="tab-pane">
                                <?= $this->render('featured-image-form', ['model' => $model]) ?>
                            </div>
                            <div id="tab_3-3" class="tab-pane">
                                <?= $this->render('password-form', ['model' => $model]) ?>
                            </div>
                        </div>
                    </div>
                    <!--end col-md-9-->
                </div>
            </div>
            <!--end tab-pane-->

            <!--end tab-pane-->
        </div>
    </div>
</div>

<?php if ($model->role == 'client'): ?>

    <!-- Modal -->
    <?= $this->render('/modal-template',
        [
            'id' => 'assignCharteringModal',
            'title' => 'Assign Chartering to User',
            'content_template' => 'users/assign-form',
            'content_data' =>
                [
                    'all' => $charterings,
                    'action' => Url::toRoute('users/assign_chartering/' . $model->user_id),
                    'id' => 'user_assign_chartering',
                    'name' => 'Chartering',
                    'value' => 'chartering_id',
                    'text' => 'title',
                    'multiple' => true,
                ]
        ]) ?>

    <!-- Modal -->
    <?= $this->render('/modal-template',
        [
            'id' => 'assignCompanyModal',
            'title' => 'Assign Company to User',
            'content_template' => 'users/assign-form',
            'content_data' =>
                [
                    'all' => $companies,
                    'action' => Url::toRoute('users/assign_company/' . $model->user_id),
                    'id' => 'user_assign_company',
                    'name' => 'company_id',
                    'value' => 'company_id',
                    'text' => 'company_name',
                    'multiple' => false,
                    'selected' => $model->company_id
                ]
        ]) ?>
<?php endif; ?>
<script>

    function updateBasicSubmit() {
        Main.save('#update-form-1', '<?=Url::toRoute("users/view/" . $model->user_id)?>');
    }

    function updatePasswordSubmit() {
        Main.save('#update-form-2', '<?=Url::toRoute("users/view/" . $model->user_id)?>');
    }

    $(document).ready(function () {

        Main.init();
        Main.initDatatable('#ongoingOperationsTable');
        Main.initDatatable('#pastOperationsTable');
        $("#marketReportsSetting").bootstrapSwitch();

        Main.initExport(".export-ongoing", "UserOngoingOperations", function () {

            var csv = $('#ongoingOperationsTable').table2CSV({delivery: 'value'});
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
            return csvData;

        });
        Main.initExport(".export-past", "UserPastOperations", function () {
            var csv = $('#pastOperationsTable').table2CSV({delivery: 'value'});
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
            return csvData;
        });

        Main.initConfirmation('.confirmation-delete', function () {
            setTimeout(function () {
                document.location = '<?=Url::toRoute("users/")?>';
            }, 2000);
        });
        Main.initConfirmation('.confirmation-assign', false, {'user_id': <?=$model->user_id?>});


        toastr.options.closeDuration = 50;


        $('#user_assign_chartering').submit(function () {


            Main.save("#user_assign_chartering", '<?=Url::toRoute("users/view/" . $model->user_id)?>', function () {
                toastr.success('Chartering successfully assigned.');
                setTimeout(function () {
                    document.location = '<?=Url::toRoute("users/view/" . $model->user_id)?>';
                }, 2000);
                return false;
            });

            return false;
        });

        $('#user_assign_company').submit(function () {

            Main.save("#user_assign_company", '<?=Url::toRoute("users/view/" . $model->user_id)?>', function () {
                toastr.success('Company successfully assigned.');
                setTimeout(function () {
                    document.location = '<?=Url::toRoute("users/view/" . $model->user_id)?>';
                }, 2000);
                return false;
            });

            return false;

        });
    });
</script>
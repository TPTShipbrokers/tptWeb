<?php
use app\models\AppUser;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$status_colors = $this->context->module->params["status_colors"];

?>

<div class="portlet light bg-inverse">
    <div class="portlet-title">
        <div class="caption red-sunglo">
            <span class="caption-subject font-red-sunglo bold  block pull-left"
                  style="padding: 5px 15px 5px 0; font-size: 16px"><b><?= $model->first_name . ' ' . $model->last_name ?></b></span>

        </div>
        <div class="actions">
            <div>
                <!-- VIEW USER DETAILS -->
                <a class="btn btn-circle btn-icon-only btn-default "
                   href="<?= Url::toRoute("users/view/$model->user_id") ?>" target="_blank">
                    <i class="fa fa-eye"></i>
                </a>

                <?php if ($model->status == 'active'): ?>
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:" data-toggle="confirmation"
                       data-original-title="Are you sure you want to block user?" data-id="<?= $model->user_id ?>"
                       data-message="User blocked." data-url="<?= Url::toRoute("users/block") ?>"
                       data-placement="bottom">
                    <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="Block user">
                      <i class="fa fa-user fa-stack-1x"></i>
                      <i class="fa fa-ban fa-stack-2x text-danger"></i>
                    </span>
                    </a>
                <?php else: ?>
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:" data-toggle="confirmation"
                       data-original-title="Are you sure you want to unblock user?" data-id="<?= $model->user_id ?>"
                       data-message="User unblocked." data-url="<?= Url::toRoute("users/block") ?>"
                       data-placement="bottom">
                    <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="Unblock user"> 
                      <i class="fa fa-user fa-stack-1x"></i>
                      <i class="fa fa-check fa-stack-2x text-success"></i>
                    </span>
                    </a>
                <?php endif; ?>


                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:" data-toggle="confirmation"
                   data-original-title="Are you sure you want to delete user permanently?"
                   data-id="<?= $model->user_id ?>" data-message="User deleted."
                   data-url="<?= Url::toRoute("users/delete") ?>" data-placement="bottom">
                    <i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete user"></i>
                </a>


            </div>


        </div>
        <div class="clearfix"></div>
    </div>

    <div class="portlet-body form" id="people-form">
        <!-- BEGIN FORM-->
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['users/update/' . $model->user_id],
            'options' => ["enctype" => "multipart/form-data"]

        ]); ?>
        <div class="form-body">

            <?= $form->field($model, 'first_name',
                [
                    'options' => ['class' => 'form-group form-md-line-input'],
                    'template' => '<div class="form-group">{input}{hint}{error}{label}</div>',
                    'inputOptions' => ['class' => 'form-control']
                ])
                ->textInput(['required' => true])
                ->label('First Name')
                ->hint('User first name.')
            ?>

            <?= $form->field($model, 'last_name',
                [
                    'options' => ['class' => 'form-group form-md-line-input'],
                    'template' => '<div class="form-group">{input}{hint}{error}{label}</div>',
                    'inputOptions' => ['class' => 'form-control']
                ])
                ->textInput(['required' => false])
                ->label('Last Name')
                ->hint('User last name.')
            ?>

            <?= $form->field($model, 'email',
                [
                    'options' => ['class' => 'form-group form-md-line-input'],
                    'template' => '<div class="form-group">{input}{hint}{error}{label}</div>',
                    'inputOptions' => ['class' => 'form-control', 'required' => true]
                ])
                ->input('email')
                ->label('Email')
                ->hint('Email address.')
            ?>
            <?php if ($model->account_type == AppUser::$account_types['STANDARD']): ?>

                <?= $form->field($model, 'password',
                    [
                        'options' => ['class' => 'form-group form-md-line-input'],
                        'template' => '<div class="form-group">{input}{hint}{error}{label}</div>',
                        'inputOptions' => ['class' => 'form-control', 'required' => false, 'value' => '']
                    ])
                    ->input('password')
                    ->label('Password')
                    ->hint('Password - leave blank to leave unchanged.')
                ?>

            <?php endif; ?>





            <?php
            $initialPreview = "";
            if ($model->profile_picture):
                $initialPreview = "<img class='file-preview-image greyscale' src='" . Url::home(true) . $model->profile_picture . "' /><input type='hidden' value='" . $model->profile_picture . "' name='AppUser[old-image]' /> ";
            endif;
            ?>

            <div class="form-group" style="margin-top: 75px">
                <div class="input-group">
                    <label for="form_control_1">Profile picture</label>
                    <input id="input-id" type="file" class="file" name="AppUser[profile_picture]"
                           data-preview-file-type="text" data-show-upload="false" data-overwrite-initial="true"
                           data-initial-preview="<?= $initialPreview ?>" value="<?= $model->profile_picture ?>"/>

                </div>
            </div>


            <?= $form->field($model, 'nationality',
                [
                    'options' => ['class' => 'form-group form-md-line-input'],
                    'template' => '<div class="form-group">{input}{hint}{error}{label}</div>',
                    'inputOptions' => ['class' => 'form-control']
                ])
                ->textInput(['required' => false])
                ->label('Nationality')
                ->hint('Users nationality.')
            ?>

            <?= $form->field($model, 'club_name',
                [
                    'options' => ['class' => 'form-group form-md-line-input'],
                    'template' => '<div class="form-group"><div class="input-group">{input}{hint}{label}</div></div>',
                    'inputOptions' => ['class' => 'form-control']
                ])
                ->textInput(['required' => false])
                ->label('Club Name')
                ->hint('Club name.');
            ?>


            <div class="form-group form-md-radios form-horizontal">
                <label class="col-md-2 pad0">Role</label>
                <div class="md-radio-inline col-md-10">
                    <div class="md-radio">
                        <input type="radio" id="radio6" name="AppUser[role]" class="md-radiobtn"
                               value="<?= $model->role ?>" <?= $model->role == 'admin' ? 'checked' : '' ?>>
                        <label for="radio6">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            Admin </label>
                    </div>
                    <div class="md-radio">
                        <input type="radio" id="radio7" name="AppUser[role]" class="md-radiobtn"
                               value="<?= $model->role ?>" <?= $model->role == 'user' ? 'checked' : '' ?>>
                        <label for="radio7">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            User </label>
                    </div>

                </div>
            </div>
            <?php if ($model->role == 'client'): ?>
                <div class="form-group form-md-radios form-horizontal">
                    <label class="control-label"> Market Reports Access </label>
                    <input type="checkbox"
                           class="make-switch" <?= $model->market_report_access_level == 1 ? "checked" : "" ?>
                           data-on="success" data-on-color="success" data-off-color="default" data-size="big"
                           name="AppUser[market_report_access_level]">


                </div>
            <?php endif; ?>

            <div class="form-group form-md-radios form-horizontal">
                <label class="col-md-2 pad0">Status</label>
                <div class="md-radio-inline col-md-10">

                    <a class="btn" href="javascript:" data-toggle="confirmation"
                       data-original-title="Are you sure you want to <?= $model->status == 'active' ? 'block' : 'unblock' ?> user?"
                       data-id="<?= $model->user_id ?>"
                       data-message="User <?= $model->status == 'active' ? 'blocked' : 'unblocked' ?>."
                       data-url="/admin/users/block">
                        <span class="<?= $status_colors[$model->status] ?>" data-toggle="tooltip" data-placement="top"
                              title="<?= $model->status == 'active' ? 'Block' : 'Unblock' ?> user"><?= $model->status ?></span>
                    </a>


                </div>
            </div>


            <div class="form-actions noborder">
                <button type="submit" class="btn green">Submit</button>

                <a type="button" class="btn default" href="<?= Url::toRoute("users/") ?>">Cancel</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <!-- END FORM-->
    </div>
</div>


<script>


    $(document).ready(function () {

        // toastr.options.onHidden = function() { location.reload(); };
        toastr.options.closeDuration = 50;

        $('[data-toggle=confirmation]').confirmation(
            {
                container: 'body',
                btnOkClass: 'btn btn-sm btn-success',
                btnOkLabel: 'Yes',
                btnCancelClass: 'btn btn-sm btn-danger',
                onConfirm: function () {
                    var id = $(this)[0].id;
                    var url = $(this)[0].url;
                    var message = $(this)[0].message;

                    $.post(url, {"user_id": id},
                        function (data) {
                            toastr.success(message);
                            //  setTimeout( function(){document.location = '<?=Url::toRoute("users/")?>';}, 3000 );


                        }, 'json');
                }
            });


    });


</script>

<script type="text/javascript">
    $(function () {

        $('[data-toggle="tooltip"]').tooltip();

        $('#people-form form').submit(function () {

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
                done: function (data) {
                    data = data.responseJSON;
                    if (data.result == "success" && data.status == 200) {
                        toastr.success('User details updated. <a href="<?=Url::toRoute("users/view/$model->user_id")?>" target="_blank" class="label label-danger">View user details </a>');
                    } else {
                        toastr.error('An error occurred while trying to update user details.');

                    }
                    return false;
                },
                fail: function (data) {

                    toastr.error('An error occurred while trying to update user details.');
                    return false;
                }

            });

            return false;


        });
    });


</script>



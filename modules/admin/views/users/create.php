<?php
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$status_colors = $this->context->module->params["status_colors"];

?>
<style>
    .form-horizontal .form-group {
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
</style>
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> User Details
    <small>create account</small>
</h3>
<!-- END PAGE TITLE-->

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
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['users/create/'],
            'options' => ["enctype" => "multipart/form-data"]

        ]); ?>
        <!--<form role="form" action="#">-->

        <?= $form->field($model, 'first_name',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control']
            ])
            ->textInput(['required' => true])
            ->label('First Name')
            ->hint('User first name.')
        ?>
        <?= $form->field($model, 'last_name',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control']
            ])
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
                <?= $form->field($model, 'phone',
                    [
                        'options' => ['class' => 'form-group form-md-line-input'],
                        'template' => '{input}{hint}{error}{label}',
                        'inputOptions' => ['class' => 'form-control']
                    ])
                    ->textInput(['required' => false])
                    ->label('Phone')
                    ->hint('Users primary phone number.')
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'phone2',
                    [
                        'options' => ['class' => 'form-group form-md-line-input'],
                        'template' => '{input}{hint}{error}{label}',
                        'inputOptions' => ['class' => 'form-control']
                    ])
                    ->textInput(['required' => false])
                    ->label('Phone 2')
                    ->hint('Users secondary phone number.')
                ?>

            </div>
            <div class="clearfix"></div>
        </div>


        <div class="form-group">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <?php if (!$model->profile_picture): ?>
                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                    <?php else: ?>
                        <img src="<?= Yii::$app->request->baseUrl ?>/<?= $model->profile_picture ?>" alt=""/>
                    <?php endif; ?>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"
                     style="max-width: 200px; max-height: 150px;"></div>

                <div>
                        <span class="btn default btn-file">
                            <span class="fileinput-new"> Select image </span>
                            <span class="fileinput-exists"> Change </span>
                            <?= $form->field($model, 'profile_picture')->fileInput()->label(false) ?> </span>
                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                </div>
            </div>

        </div>


        <?= $this->render('/radio-group-control',
            ['model' => $model, 'attribute' => 'role', 'label' => 'Role', 'name' => 'AppUser[role]', 'values' => ['Admin' => 'admin', 'Client' => 'client', 'Team' => 'team']]) ?>

        <div class="form-group form-md-radios form-horizontal">
            <label class="control-label"> Market Reports Access </label>
            <?php $model->market_report_access_level = 1; ?>

            <?= $form->field($model, 'market_report_access_level')->checkbox([
                'label' => '',
                'labelOptions' => ['style' => 'padding:5px;'],

                'class' => 'make-switch', 'data' => ['on' => 'success', 'on-color' => 'success', 'off-color' => 'default', 'size' => 'big', 'id' => 'marketReportsSetting']])
                ->label(false);
            ?>
        </div>

        <?= $form->field($model, 'position',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control']
            ])
            ->textInput(['required' => false])
            ->label('Position')
            ->hint('User position. Relevant only for Team members. ex. Account Manager, Operations Manager, Client Services ...')
        ?>


        <div class="margiv-top-10">
            <button type="submit" class="btn green"> Save Changes</button>
            <a href="<?= Url::toRoute('users/view/' . $model->user_id) ?>" class="btn default"> Cancel </a>
        </div>
        <!--</form>-->
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
                            setTimeout(function () {
                                document.location = '<?=Url::toRoute("users/")?>';
                            }, 3000);


                        }, 'json'
                    );
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
                statusCode: {
                    500: function () {
                        toastr.error('An error occurred while trying to save user details.');
                        return false;
                    },
                    200: function (data) {
                        if (data.result == "success" && data.status == 200) {
                            toastr.success('User account successfully created. Login instructions have been sent to client.');
                            setTimeout(function () {
                                document.location = '<?=Url::toRoute("users/")?>';
                            }, 2000);
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



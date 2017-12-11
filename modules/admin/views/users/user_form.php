<?php
use yii\bootstrap\ActiveForm;


?>
<style>
    .form-horizontal .form-group {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['users/create/'],
    'options' => ["enctype" => "multipart/form-data", "id" => "people-form"]

]); ?>

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


        <?= $form->field($user, 'first_name',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control']
            ])
            ->textInput(['required' => true])
            ->label('First Name')
            ->hint('User first name.')
        ?>
        <?= $form->field($user, 'last_name',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control']
            ])
            ->textInput(['required' => true])
            ->label('Last Name')
            ->hint('User last name.')
        ?>
        <?= $form->field($user, 'email',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control', 'required' => true]
            ])
            ->input('email')
            ->label('Email')
            ->hint('Email address.')
        ?>
        <?= $form->field($user, 'phone',
            [
                'options' => ['class' => 'form-group form-md-line-input'],
                'template' => '{input}{hint}{error}{label}',
                'inputOptions' => ['class' => 'form-control']
            ])
            ->textInput(['required' => false])
            ->label('Phone')
            ->hint('Users telephone.')
        ?>

        <div class="form-group">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <?php if (!$user->profile_picture): ?>
                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                    <?php else: ?>
                        <img src="<?= Yii::$app->request->baseUrl ?>/<?= $user->profile_picture ?>" alt=""/>
                    <?php endif; ?>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"
                     style="max-width: 200px; max-height: 150px;"></div>

                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <?= $form->field($user, 'profile_picture')->fileInput()->label(false) ?> </span>
                    <a href="javascript:" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                </div>
            </div>

        </div>
        <div class="form-group form-md-radios form-horizontal">
            <label class="control-label"> Market Reports Access </label>
            <?= $form->field($user, 'market_report_access_level')->checkbox([
                'label' => '',
                'labelOptions' => ['style' => 'padding:5px;'],
                'class' => 'make-switch', 'data' => ['on' => 'success', 'on-color' => 'success', 'off-color' => 'default', 'size' => 'big', 'id' => 'marketReportsSetting']])
                ->label(false);
            ?>
        </div>
        <?php if ($role): ?>
            <input type="hidden" name="AppUser[role]" class="md-radiobtn" value="<?= $role ?>">


        <?php endif; ?>
        <div class="clearfix"></div>

    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-success" type="submit">Save</button>
    <button class="btn btn-default btn-cancel" data-dismiss="modal" type="button">Cancel</button>
</div>
<?php ActiveForm::end(); ?>

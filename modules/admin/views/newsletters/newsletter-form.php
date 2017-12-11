<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>

<div class="well ">

    <?php
    if ($model->isNewRecord) {
        $action = 'newsletters/create/';
    } else {
        $action = 'newsletters/update/' . $model->newsletter_id;
    }
    ?>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => [$action],
        'options' => ["enctype" => "multipart/form-data", 'class' => '', 'id' => 'newNewsletterForm']

    ]); ?>


    <div class="panel-body">


        <div class="portlet light bg-inverse">
            <?php if ($model->isNewRecord): ?>
                <div class="portlet-title">
                    <div class="caption red-sunglo">
                        <span class="caption-subject font-red-sunglo bold  block pull-left"
                              style="padding: 5px 15px 5px 0; font-size: 16px"><b>Create New Newsletter</b></span>

                    </div>

                    <div class="clearfix"></div>
                </div>
            <?php endif; ?>

            <div class="portlet-body form">

                <?=
                $form->field($model, 'title',
                    [
                        'options' => ['class' => 'form-group form-md-line-input'],
                        'template' => '{input}{hint}{error}<div class="form-control-focus"> </div>',
                        'inputOptions' => ['class' => 'form-control']
                    ])
                    ->textInput(['required' => true, 'placeholder' => 'Newsletter Title'])
                    ->label(false)
                    ->hint('Newsletter title.')
                ?>

                <h3 class="block">Add Market Report Document</h3>

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


                        <span class="btn default btn-file">
                            <span class="fileinput-new"> Select file </span>
                            <span class="fileinput-exists"> Change </span>
                            <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                         </span>
                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
                            Remove </a>
                    </div>

                </div>

                <button type="button" class="btn green" onclick="saveNewsletter()"> Save</button>
                <a data-toggle="collapse" data-parent="#accordion1" href="#accordion_create" aria-expanded="false"
                   class="btn default accordion-toggle collapsed "> Cancel </a>


            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>
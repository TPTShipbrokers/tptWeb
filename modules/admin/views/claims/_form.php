<?php

use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Claims */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="claims-form">
    <?php if (isset($model) && $model): ?>


        <?php $form = ActiveForm::begin([
            'action' => $model->isNewRecord ? Url::toRoute('claims/create') : Url::toRoute('claims/update/' . $model->claim_id),
            'options' => [
                'id' => $model->isNewRecord ? 'newClaimForm' : 'updateClaimForm',
                "enctype" => "multipart/form-data",
                "data" => ["id" => $model->claim_id]
            ]
        ]); ?>

        <?= $form->field($model, 'description')->textArea(['rows' => 10]) ?>

        <?php /*
    <?= $form->field($model, 'owners_claim')->textInput(['type' => 'number', 'step' => '0.1']) ?>

    <?= $form->field($model, 'owners_claim_reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'charterers_claim')->textInput(['type' => 'number', 'step' => '0.1']) ?>

    <?= $form->field($model, 'charterers_claim_reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>
 */ ?>
        <?= $form->field($model, 'chartering_id')->hiddenInput(['value' => $chartering_id])->label(false) ?>

        <div class="form-group">
            <label class="col-md-3 control-label"> Documents </label>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 400px; ">
                    <?php if (!empty($model->claimDocumentations)): ?>
                        <div class="update-pane">
                            <div class="form-group">
                                <?php foreach ($model->claimDocumentations as $doc): ?>
                                    <div id="claim_doc_row<?= $doc->claim_documentation_id ?>">
                                        <a class="btn btn-sm grey-salsa btn-outline"
                                           href="#claim_doc_<?= $doc->claim_documentation_id ?>"
                                           data-toggle="collapse"
                                           target="_blank"
                                           class="btn green  btn-outline accordion-toggle collapsed"
                                           aria-expanded="false">
                                            <?= $doc->filename ? $doc->filename : "View Document" ?>
                                        </a>
                                        <p id="claim_doc_<?= $doc->claim_documentation_id ?>"
                                           class="panel-collapse collapse"
                                           aria-expanded="false">
                                            <a href="javascript:;"
                                               class="confirmation-claim-doc btn"
                                               data-idprefix="#claim_doc_row"
                                               data-id="<?= $doc->claim_documentation_id ?>"
                                               data-url="<?= Url::toRoute('claims/remove_claim_documentation/' . $doc->claim_documentation_id) ?>"
                                               data-message="Document successfully removed from claim."
                                               data-errormessage="An error occured while trying to remove document.">
                                                <i class="fa fa-close"></i> Remove document </a>
                                            <a class="btn btn-success"
                                               href="<?= Yii::$app->request->baseUrl . '/' . $doc->file ?>"
                                               target="_blank"> View document
                                            </a>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="label label-danger">not ready</span>
                    <?php endif; ?>
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"
                     style="max-width: 200px; max-height: 150px;"></div>
                <div>
                    <span class="btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <?= $form->field($model, 'claim_documentations[]')->fileInput(['multiple' => true])->label(false) ?> </span>
                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">Remove </a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-success claim-form-btn" type="button"
                    onclick="submitClaimForm('<?= $model->isNewRecord ? '#newClaimForm' : '#updateClaimForm' ?>', <?= !$model->isNewRecord ? $model->claim_id : -1 ?>)">
                Save
            </button>
        </div>

    <?php ActiveForm::end(); ?>

        <script>
            <?php if(!$model->isNewRecord): ?>
            $(document).ready(function () {
                $('body').on('click', '.confirmation-claim-doc', function () {
                    var url = $(this).data('url');
                    var row_id = $(this).data('idprefix') + $(this).data('id');
                    $.post(url, {'claim_id': <?=$model->claim_id?>},
                        function (data) {
                            if (data.result == 'success') {
                                $(row_id).fadeOut();
                                $(row_id).remove();
                                toastr.success(message);
                            } else {
                                toastr.error(data.message + ' ' + data.data.error_description);
                            }
                        }, 'json'
                    );
                });
            });
            <?php endif; ?>
        </script>
    <?php endif; ?>

</div>


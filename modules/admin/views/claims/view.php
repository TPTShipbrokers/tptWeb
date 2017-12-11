<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Claims */
?>

<div id="claim_row<?= $model->claim_id ?>">
    <div class="well">
        <?php if (isset($actions) && $actions == true): ?>
            <div class="form-actions">
                <button class="btn btn-success update-claim-btn" type="button"
                        data-url="<?= Url::toRoute('claims/details/' . $model->claim_id) ?>">
                    <i class="fa fa-cogs"></i> Update
                </button>
                <button class="btn btn-danger confirmation-delete-claim" type="button"
                        href="javascript:"
                        data-original-title="Are you sure you want to delete claim permanently?"
                        data-id="<?= $model->claim_id ?>"
                        data-idprefix="#claim_row"
                        data-message="Claim deleted."
                        data-errormessage="An error ocurred while tryng to delete claim and its details."
                        data-url="<?= Url::toRoute("claims/delete/" . $model->claim_id) ?>"
                        data-placement="bottom">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete claim"></i> Delete
                </button>

            </div>
        <?php endif; ?>
        <hr>
        <div class="row">
            <div class="col-md-8 text-left"><?= $model->description ?></div>

            <div class="clearfix"></div>
        </div>

        <?php /*<div class="row">
                <div class="col-md-4">Owners claim:</div>
                <div class="col-md-4"><?=$model->owners_claim?></div>
                <div class="col-md-4"><?=$model->owners_claim_reason?></div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row"> 
                <div class="col-md-4">Charterers claim:</div>
                <div class="col-md-4"><?=$model->charterers_claim?></div>
                <div class="col-md-4"><?=$model->charterers_claim_reason?></div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="row"> 
                <div class="col-md-4">Comments:</div>
                <div class="col-md-8"><?=$model->comments?></div>
                
                <div class="clearfix"></div>
            </div>
            */ ?>
        <hr>
        <div class="row">
            <div class="col-md-4">Documents:</div>
            <div class="col-md-8">
                <?php foreach ($model->claimDocumentations as $doc): ?>
                    <a class="btn btn-sm grey-salsa btn-outline"
                       href="<?= Yii::$app->request->baseUrl . '/' . $doc->file ?>"
                       target="_blank"><?= $doc->filename; ?></a>
                <?php endforeach; ?>
            </div>

            <div class="clearfix"></div>
        </div>

        <?php /*
            <hr>
            <div class="row"> 
                <div class="col-md-4">Status:</div>
                <div class="col-md-8"><span class="label label-info"><?=$model->status?></span></div>
                
                <div class="clearfix"></div>
            </div>
            */ ?>
    </div>
</div>
                               

<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Chartering */

?>


<div class="well">

    <hr>
    <div class="row">
        <div class="col-md-4">Tanker:</div>
        <div class="col-md-8"><?= $model->vessel_name ?></div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">Subs due:</div>
        <div class="col-md-8"><?= date('d M, Y H:i', strtotime($model->subs_due)) ?></div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">Status:</div>
        <div class="col-md-8">
            <?php if ($model->status): ?>
                <span class="label label-info"> 
                              
                              
                                <i class="fa fa-check"></i>
                    <?= $model->status->status->description ?> 

                            </span>
                <br>
                <br>
                <span class="date"><?= date('d M, Y H:i', strtotime($model->status->datetime)) ?></span>

            <?php else: ?>
                <span class="label label-warning"> No status set </span>
            <?php endif; ?>

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">Ship documentation:</div>
        <div class="col-md-8">

            <?php if ($model->ship_documentation): ?>
                <div class="update-pane">

                    <div class="form-group">

                        <a class="btn btn-sm grey-salsa btn-outline"
                           href="<?= Yii::$app->request->baseUrl . '/' . $model->ship_documentation ?>" target="_blank">View
                            Document</a>

                    </div>
                </div>

            <?php else: ?>
                <span class="label label-danger">not ready</span>
            <?php endif; ?>

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>


    <hr>
    <div class="row">
        <div class="col-md-4">Broker:</div>
        <div class="col-md-8">

            <?php if ($model->broker_id): ?>
                <div class="update-pane">

                    <div class="form-group">

                        <?php $broker = $model->getBroker()->one(); ?>

                        <a class="btn btn-sm grey-salsa btn-outline"
                           href="<?= Url::toRoute('users/view/' . $broker->user_id) ?>"
                           target="_blank"><?= $broker->first_name . " " . $broker->last_name ?></a>

                    </div>
                </div>

            <?php else: ?>
                <span class="label label-danger">not assigned</span>
            <?php endif; ?>

        </div>
        <div class="clearfix"></div>
    </div>
    <a href="<?= Url::toRoute('chartering/view/' . $model->chartering_id) ?>" class="btn btn-danger" target="_blank">View
        more details</a>
</div>
          
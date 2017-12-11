<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationReport */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Operation Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-operation-report-index">


    <h3 class="page-title"> <?= Html::encode($this->title) ?>
        <small>create & manage</small>
    </h3>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>Create Post Operation Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-md-12">
            <!--<div class="note note-danger">
            </div>-->
            <!-- Begin: life time stats -->
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">Post Operation Reports</span>
                    </div>
                    <!--<div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn btn-transparent grey-salsa btn-outline btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                            <label class="btn btn-transparent grey-salsa btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                        </div>
                        <div class="btn-group">
                            <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                <i class="fa fa-share"></i>
                                <span class="hidden-xs"> Tools </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;"> Export to Excel </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Export to CSV </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Export to XML </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;"> Print Invoices </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span> </span>
                            <select class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>
                                <option value="Cancel">Cancel</option>
                                <option value="Cancel">Hold</option>
                                <option value="Cancel">On Hold</option>
                                <option value="Close">Close</option>
                            </select>
                            <button class="btn btn-sm green table-group-action-submit">
                                <i class="fa fa-check"></i> Submit
                            </button>
                        </div>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'id' => 'dataTableUsers',
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'Mooring Master',
                                    'content' => function ($data) {
                                        return Html::a($data->mooringMaster->first_name . ' ' . $data->mooringMaster->last_name, ['users/view/', 'id' => $data->mooringMaster->user_id], ['target' => '_blank']);
                                    },
                                ],
                                [
                                    'attribute' => 'Supply Vessel',
                                    'content' => function ($data) {
                                        return $data->supplyVessel->name;
                                    },
                                ],
                                [
                                    'attribute' => 'Location',
                                    'content' => function ($data) {
                                        if ($data->operation)
                                            return $data->operation->location->title;
                                        else
                                            return '<span class="label label-danger"> Operation no assigned</span>';
                                    },
                                ],
                                [
                                    'attribute' => 'Fenders Supplied',
                                    'content' => function ($data) {
                                        return $data->fenders_supplied;
                                    },
                                ],
                                [
                                    'attribute' => 'Hoses Supplied',
                                    'content' => function ($data) {
                                        return $data->hoses_supplied;
                                    },
                                ],
                                [
                                    'attribute' => 'Cargo Parcel',
                                    'content' => function ($data) {
                                        return $data->cargo_parcel;
                                    },
                                ],
                                [
                                    'attribute' => 'Report PDF',
                                    'content' => function ($data) {

                                        if ($data->file) {
                                            return '<a class="btn btn-sm blue btn-outline" href="' . Yii::$app->request->baseUrl . '/' . $data->file . '" target="_blank">PDF</a>';
                                        } else {
                                            return '<span class="label label-danger">not ready</span>';
                                        }

                                    },
                                ],


                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>

                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>


</div>

<script>
    var table = $('#dataTableUsers table').DataTable({
        responsive: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

    });
</script>

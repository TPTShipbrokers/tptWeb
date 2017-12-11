<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VesselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAF Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vessel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php $form = ActiveForm::begin(['action' => Url::toRoute('waf-positions/upload'),
            'options' => ['enctype' => 'multipart/form-data', 'method' => 'post', 'id' => 'csv-form']]); //important?>

    <div class="form-group" style="display:inline">
        <label class="col-md-3 control-label"> Upload from document </label>
        <div class="fileinput fileinput-new" data-provides="fileinput">

            <div>
                      <span class="btn default btn-file">
                          <span class="fileinput-new"> <i class="fa fa-plus"></i>  Select file </span>
                       
                          <input type="file" name="csv"/>
                          <?= $form->field($uploadModel, 'file')->fileInput([])->label(false); ?>

                      </span>
                <button type="submit" class="btn btn-primary default " data-dismiss="fileinput"
                        onclick="$('#csv-form').submit()"><i class="fa fa-upload"></i> Upload
                </button>

            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?= Html::a('Add New', ['create'], ['class' => 'btn btn-success', 'style' => "display: inline"]) ?>
    <a class="red btn accordion-toggle collapsed" data-toggle="collapse" href="#search-collapse"
       aria-expanded="false"><i class="fa fa-search"></i> Advanced Search</a>
    <div class="collapse panel-collapse" id="search-collapse" aria-expanded="false">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    </p>


    <div class="form-group">
        <?= Html::a('Select All', false, ['class' => 'btn btn-success', 'style' => "display: inline", 'id' => 'select-all']) ?>
        <?= Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete selected records"></i> Delete Selected', 'javascript:;', [
            'title' => Yii::t('yii', 'Delete Selected'), 'class' => 'btn  red confirmation-delete-selected',
            'data' => [
                'original-title' => 'Are you sure you want to delete selected records permanently?',
                'message' => 'Records deleted',
                'errormessage' => 'An error ocurred while trying to delete records.',
                'url' => Url::toRoute("waf-positions/delete_selected"),
                'placement' => 'bottom'
            ]
        ]); ?>
        <?= Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete all records"></i> Delete All', 'javascript:;', [
            'title' => Yii::t('yii', 'Delete All'), 'class' => 'btn  red confirmation-delete-selected',
            'data' => [
                'original-title' => 'Are you sure you want to delete selected records permanently?',
                'message' => 'Records deleted',
                'errormessage' => 'An error ocurred while trying to delete records.',
                'url' => Url::toRoute("waf-positions/delete_all"),
                'placement' => 'bottom'
            ]
        ]); ?>
    </div>
    <div class="btn-group">
        <a href="" class="btn red btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
           data-close-others="true" aria-expanded="false" style="padding: 7px 25px; margin-top: 2px;">
            Filter Vessels
            <span class="fa fa-angle-down"> </span>
        </a>
        <br><br>
        <ul class="dropdown-menu pull-right">
            <li class="<?= Url::toRoute('waf-positions/index') == Url::current() ? 'active' : '' ?>">
                <a href="<?= Url::toRoute('waf-positions/index') ?>">
                    All
                </a>
            </li>
            <li class="<?= Url::toRoute('waf-positions/index/1') == Url::current() ? 'active' : '' ?>">
                <a href="<?= Url::toRoute('waf-positions/index/1') ?>">
                    Positions
                </a>
            </li>

            <li class="<?= Url::toRoute('waf-positions/index/0') == Url::current() ? 'active' : '' ?>">
                <a href="<?= Url::toRoute('waf-positions/index/0') ?>">
                    Chartering
                </a>
            </li>

        </ul>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'id' => 'positionsTable',
        // 'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => 'row' . $model->vessel_id];
        },
        'showOnEmpty' => false,
        'columns' => [

            ['class' => 'yii\grid\CheckboxColumn', 'name' => 'id[]'

            ],
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'size',
            'grade',
            'built',
            'status',
            'open_date:date',
            'location:ntext',
            //    'cbm',
            //   'dwt',
            //   'loa',
            //  'last:ntext',
            //  'imo',
            //  'hull:ntext',
            //  'sire',
            // 'intake',
            'tema_suitable',
            //  'cabotage:ntext',
            //  'nigerian_cab:ntext',
            //  'comments:ntext',
            'last_update:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View Details"></i>', $url, [
                            'title' => Yii::t('yii', 'View'), 'class' => 'btn btn-circle btn-icon-only default'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        //return Html::a('<i class="icon-wrench" data-toggle="tooltip" data-placement="top" title="Update"></i>', $url, [
                        //        'title' => Yii::t('yii', 'Update'), 'class' => 'btn btn-circle btn-icon-only green'
                        //]);

                        return Html::a('<i class="icon-wrench" title="Update"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'), 'class' => 'btn btn-circle btn-icon-only green',
                            'data-remote' => 'false',
                            'data-toggle' => 'modal',
                            'data-target' => '#updatePosition'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete tanker"></i>', 'javascript:;', [
                            'title' => Yii::t('yii', 'Delete'), 'class' => 'btn btn-circle btn-icon-only red confirmation-delete',
                            'data' => [
                                'original-title' => 'Are you sure you want to delete vessel permanently?',
                                'id' => $model->vessel_id,
                                'message' => 'Vessel deleted',
                                'errormessage' => 'An error ocurred while trying to delete record.',
                                'url' => Url::toRoute("waf-positions/delete/" . $model->vessel_id),
                                'placement' => 'bottom'
                            ]
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>

<div class="modal fade" id="updatePosition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Tanker</h4>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        Main.initDatatable('#positionsTable table');
        Main.initConfirmation('.confirmation-delete');

        $('.confirmation-delete-selected').confirmation({
            container: 'body',
            btnOkClass: 'btn btn-sm btn-success',
            btnOkLabel: 'Delete ',
            btnCancelClass: 'btn btn-sm btn-danger',

            onConfirm: function () {
                var id = $(this)[0].id;
                var prefix = $(this)[0].idprefix;
                var url = $(this)[0].url;
                var message = $(this)[0].message;
                var error_message = $(this)[0].errormessage;
                var keys = [];
                $('#positionsTable table').find("input[name=id\\[\\]]:checked").each(function () {
                    keys.push($(this).val());
                });
                console.log(keys);

                $.post(url, {ids: keys},
                    function (data) {


                        if (data.result == 'success') {

                            toastr.success(message);

                            setTimeout(function () {
                                location.reload()
                            }, 3000);


                        } else {
                            toastr.error(data.message + ' <br> ' + data.data.error_description);
                        }


                    }, 'json'
                );
            }
        });

        $("input[name=id_all], #select-all").click(function () {
            var checkBoxes = $("input[name=id\\[\\]]");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            checkBoxes.parent().toggleClass('checked');

        });

        $("#updatePosition").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-body").load(link.attr("href"));
        });
    });
</script>

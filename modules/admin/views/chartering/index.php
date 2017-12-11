<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CharteringSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chartering';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chartering-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Chartering', ['create'], ['class' => 'btn btn-success']) ?>
        <a class="red btn accordion-toggle collapsed" data-toggle="collapse" href="#search-collapse"
           aria-expanded="false"><i class="fa fa-search"></i> Advanced Search</a>
    <div class="collapse panel-collapse" id="search-collapse" aria-expanded="false">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'charteringTable',
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => 'row' . $model->chartering_id];
        },
        'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'chartering_id',
            [
                'attribute' => 'vessel_name',
                'value' => function ($data) {
                    return empty($data->vessel) ? $data->vessel_name : $data->vessel->name;
                }
            ],
            //'vessel.name',
            'subs_due:datetime',
            [
                'attribute' => 'ship_documentation',
                'label' => 'Ship documentation',
                'format' => 'html',
                'content' => function ($data) {
                    if ($data->ship_documentation)
                        return Html::a('View doc', $data->ship_documentation, ['class' => 'btn btn-sm red-sunglo btn-outline']);
                    else
                        return '<span class="label label-danger">Not ready</span>';
                }
            ],

            [
                'attribute' => 'status.status.description',
                'label' => 'Status Description',
                'format' => 'html',
                'content' => function ($data) {
                    if ($data->status)
                        return '<span class="label label-success">' . $data->status->status->description . '</span>';
                }
            ],

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
                        return Html::a('<i class="icon-wrench" data-toggle="tooltip" data-placement="top" title="Update"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'), 'class' => 'btn btn-circle btn-icon-only green'
                        ]);

                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete chartering"></i>', 'javascript:;', [
                            'title' => Yii::t('yii', 'Delete'), 'class' => 'btn btn-circle btn-icon-only red confirmation-delete',
                            'data' => [
                                'original-title' => 'Are you sure you want to delete chartering permanently?',
                                'id' => $model->chartering_id,
                                'message' => 'Chartering deleted',
                                'errormessage' => 'An error ocurred while trying to delete record.',
                                'url' => Url::toRoute("chartering/delete/" . $model->chartering_id),
                                'placement' => 'bottom'


                            ]
                        ]);

                    }
                ]

            ],
        ],
    ]); ?>


</div>

<script>

    $(document).ready(function () {
        Main.initDatatable('#charteringTable table');
        Main.initConfirmation('.confirmation-delete');
    });


</script>

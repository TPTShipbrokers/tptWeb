<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'invoicesTable',
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['id' => 'row' . $model->invoice_id];
    },
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'chartering_id',
            'label' => 'Chartering',
            'format' => 'html',
            'content' => function ($data) {
                if ($data->chartering_id)
                    return Html::a('View chartering details', Url::toRoute('chartering/view/' . $data->chartering_id), ['class' => 'btn btn-sm red-sunglo btn-outline']);
                else
                    return '<span class="label label-danger">Not assigned</span>';

            }
        ],
        'invoice_number',
        [
            'attribute' => 'vessel.name',
            'label' => 'Tanker',
            'format' => 'html'
        ],
        'fixture_ref',
        // 'reference',
        // 'cp_date',
        // 'freight:ntext',
        // 'commission_percentage',
        // 'VAT',
        'total',
        'status',
        'due_date:datetime',
        'start_period:datetime',
        'end_period:datetime',

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
                    return Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete user"></i>', 'javascript:;', [
                        'title' => Yii::t('yii', 'Delete'), 'class' => 'btn btn-circle btn-icon-only red confirmation-delete',
                        'data' => [
                            'original-title' => 'Are you sure you want to delete user permanently?',
                            'id' => $model->invoice_id,
                            'message' => 'Invoice deleted',
                            'errormessage' => 'An error ocurred while trying to delete record.',
                            'url' => Url::toRoute("invoices/delete/" . $model->invoice_id),
                            'placement' => 'bottom'


                        ]
                    ]);

                }
            ]

        ],
    ],
]); ?>


<script>

    $(document).ready(function () {
        Main.initDatatable('#invoicesTable table');
        Main.initConfirmation('.confirmation-delete');
    });


</script>


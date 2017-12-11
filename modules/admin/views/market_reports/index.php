<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsletterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Market Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add New', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'id' => 'reportsTable',
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => 'row' . $model->newsletter_id];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title:ntext',
            'date',
            'date:datetime',
            [
                'attribute' => 'file',
                'label' => 'File',
                'format' => 'html',
                'content' => function ($data) {
                    if ($data->file)
                        return Html::a('View document', Url::base().'/'.$data->file, ['class' => 'btn btn-sm red-sunglo btn-outline']);
                    else
                        return '<span class="label label-danger">Not ready</span>';
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
                        return Html::a('<i class="icon-trash" data-toggle="tooltip" data-placement="top" title="Delete market report"></i>', 'javascript:;', [
                            'title' => Yii::t('yii', 'Delete'), 'class' => 'btn btn-circle btn-icon-only red confirmation-delete',
                            'data' => [
                                'original-title' => 'Are you sure you want to delete market report permanently?',
                                'id' => $model->newsletter_id,
                                'message' => 'Market report deleted',
                                'errormessage' => 'An error ocurred while trying to delete record.',
                                'url' => Url::toRoute("market_reports/delete/" . $model->newsletter_id),
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
        Main.initDatatable('#reportsTable table');
        Main.initConfirmation('.confirmation-delete');
    });


</script>

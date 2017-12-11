<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Vessel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vessels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h3></h3>
<br>
<div class="vessel-view">

    <?= $this->render('/detail-view', [
            'title' => 'Positions',
            'pk' => 'vessel_id',
            'controller' => 'waf-positions',
            'model' => $model,
            'attributes' => [
                'name',
                'size',
                'grade',
                'built',
                'status',
                'open_date:datetime',
                'location:ntext',
                'cbm',
                'dwt',
                'loa',
                'last:ntext',
                'imo',
                'hull:ntext',
                'sire',
                'intake',
                'tema_suitable',
                'cabotage:ntext',
                'nigerian_cab:ntext',
                'comments:ntext',
                'last_update:datetime',
                [
                    'attribute' => 'positions_visible',
                    'label' => 'Visible on positions list',
                    'format' => 'html',
                    'value' => $model->positions_visible ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>'

                ],
                [
                    'attribute' => 'broker_id',
                    'label' => 'Broker',
                    'format' => 'html',
                    'value' => $model->broker ? Html::a($model->broker->first_name . ' ' . $model->broker->last_name, Url::toRoute('users/view/' . $model->broker_id), ['class' => 'btn btn-sm red-sunglo btn-outline']) : '<span class="label label-danger">Not assigned</span>'

                ],
            ]
        ]
    ) ?>
</div>

<script>
    $(document).ready(function () {

        Main.initConfirmation('.confirmation-delete', function (data) {

            if (data.result == 'success') {

                toastr.success('Item successfully deleted.');
                setTimeout(function () {
                    window.location = '<?=Url::toRoute("waf-positions/")?>';
                }, 3000);

            } else {
                toastr.error(data.message + ' ' + data.data.error_description);
            }

        });
    });
</script>


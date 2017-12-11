<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Newsletter */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Newsletters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3></h3>
<br>
<div class="newsletter-view">

    <?= $this->render('/detail-view', [
            'model' => $model,
            'title' => "Market Reports",
            'pk' => 'newsletter_id',
            'controller' => 'market_reports',
            'attributes' => [
                'title:ntext',
                'date:datetime',
                [
                    'attribute' => 'file',
                    'label' => 'File',
                    'format' => 'html',
                    'value' => $model->file ? Html::a('View document', Url::home(true) . $model->file, ['class' => 'btn btn-sm red-sunglo btn-outline']) : '<span class="label label-danger">Not ready</span>'
                ],
            ],
        ]
    ) ?>
</div>
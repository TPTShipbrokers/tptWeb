<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = 'Create Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-create col-md-8 col-md-offset-2">


    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">

            <div class="caption">
                <span class="caption-subject font-green-sharp bold "> <h1><i
                                class="fa fa-edit"></i><?= Html::encode($this->title) ?></h1></span>
            </div>


        </div>
        <div class="portlet-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
<div class="clearfix"></div>


<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = 'Update Invoice: ' . ' ' . $model->invoice_id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->invoice_id, 'url' => ['view', 'id' => $model->invoice_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="invoice-update col-md-8 col-md-offset-2">


    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">

            <div class="caption pull-left">
                <span class="caption-subject font-green-sharp bold "> <h1><i
                                class="fa fa-edit"></i><?= Html::encode($this->title) ?></h1></span>

            </div>
            <div class="pull-right">
                <?= Html::a('View Details', ['view', 'id' => $model->invoice_id], ['class' => 'btn btn-success']) ?>
                <button class="btn btn-danger confirmation-delete" type="button"
                        href="javascript:"
                        data-original-title="Are you sure you want to delete this item?"
                        data-id="<?= $model->invoice_id ?>"
                        data-idprefix="#row"
                        data-message="Item deleted."
                        data-errormessage="An error ocurred while tryng to delete item and its details."
                        data-url="<?= Url::toRoute("invoices/delete/" . $model->invoice_id) ?>"
                        data-placement="bottom">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete item"></i> Delete
                </button>

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
<script>

    $(document).ready(function () {

        Main.initConfirmation('.confirmation-delete', function (data) {

            if (data.result == 'success') {

                toastr.success('Item successfully deleted.');
                setTimeout(function () {
                    window.location = '<?=Url::toRoute("invoices/")?>';
                }, 3000);

            } else {
                toastr.error(data.message + ' ' + data.data.error_description);
            }

        });
    });
</script>


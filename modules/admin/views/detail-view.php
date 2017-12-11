<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="portlet light bordered">
    <div class="portlet-title tabbable-line mt-element-ribbon">

        <div class="caption pull-left">

            <i class="fa fa-<?= isset($icon) ? $icon : 'cogs' ?>"></i>
            <span class="caption-subject font-green-sharp bold uppercase"><?= $title ?></span>

        </div>
        <div class="hide-print pull-right">
            <?= Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->{$pk}], ['class' => 'btn green btn-sm']) ?>
            <a href="javascript:" onclick="window.print();" class=" btn blue btn-sm"><i
                        class="fa fa-print"></i>Print</a>
            <button class="btn btn-danger confirmation-delete" type="button"
                    href="javascript:"
                    data-original-title="Are you sure you want to delete this item?"
                    data-idprefix="#row"
                    data-id="<?= $model->{$pk} ?>"
                    data-message="Item deleted."
                    data-errormessage="An error ocurred while trying to delete item and its details."
                    data-url="<?= Url::toRoute($controller . "/delete/" . $model->{$pk}) ?>"
                    data-placement="bottom">
                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete item"></i> Delete
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <div class="well">
            <?= \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => $attributes,
            ]) ?>
        </div>
    </div>
    <!--END TABS-->
</div>
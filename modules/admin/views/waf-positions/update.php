<?php

use app\models\AppUser;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Vessel */

$this->title = 'Update Tanker: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tanker', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->vessel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="vessel-update col-md-8 col-md-offset-2">


    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">

            <div class="caption pull-left">
                <span class="caption-subject font-green-sharp bold "> <h1><i
                                class="fa fa-edit"></i><?= Html::encode($this->title) ?></h1></span>

            </div>
            <div class="pull-right">
                <?= Html::a('View Details', ['view', 'id' => $model->vessel_id], ['class' => 'btn btn-success']) ?>
                <button class="btn btn-danger confirmation-delete" type="button"
                        href="javascript:"
                        data-original-title="Are you sure you want to delete this item?"
                        data-id="<?= $model->vessel_id ?>"
                        data-idprefix="#row"
                        data-message="Tanker deleted."
                        data-errormessage="An error ocurred while tryng to delete item and its details."
                        data-url="<?= Url::toRoute("waf-positions/delete/" . $model->vessel_id) ?>"
                        data-placement="bottom">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete item"></i> Delete
                </button>

            </div>


        </div>
        <div class="portlet-body">

            <?= $this->render('_form', [
                'model' => $model,
                'all_team' => $all_team,
                'broker' => $model->broker_id
            ]) ?>
        </div>
    </div>

</div>
<div class="clearfix"></div>
<?= $this->render('/modal-template', ['id' => 'newBrokerModal', 'title' => 'User Details', 'subtitle' => 'create account', 'content_template' => 'users/user_form', 'content_data' => ['user' => new AppUser, 'role' => 'team']]); ?>

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

        $('#newBrokerModal form').submit(function () {

            $form = $(this);
            $data = new FormData(this);


            $.ajax({
                url: $form.attr('action'),
                type: "POST",
                data: $data,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                statusCode: {
                    500: function () {
                        toastr.error('An error occurred while trying to save user details.');
                        return false;
                    },
                    200: function (data) {
                        if (data.result == "success" && data.status == 200) {

                            toastr.success('Broker account successfully created.');
                            $("#assignBrokerForm select").append("<option value='" + data.data.user_id + "' selected>" + data.data.first_name + " " + data.data.last_name + "</option>");
                            $("#newBrokerModal").modal('hide');

                            return false;
                        } else {
                            toastr.error(data.data.error_description);
                            return false;

                        }
                    },
                },
            });


            return false;
        });

        $('#newBrokerModal form .btn-cancel').click(function () {
            $('#newBrokerModal').modal('hide');
        });


    });
</script>

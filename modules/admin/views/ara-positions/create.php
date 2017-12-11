<?php

use app\models\AppUser;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vessel */

$this->title = 'Create Tanker';
$this->params['breadcrumbs'][] = ['label' => 'Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vessel-create col-md-8 col-md-offset-2">


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
                'all_team' => $all_team,
                'broker' => false
            ]) ?>
        </div>
    </div>

</div>
<div class="clearfix"></div>
<?= $this->render('/modal-template', ['id' => 'newBrokerModal', 'title' => 'User Details', 'subtitle' => 'create account', 'content_template' => 'users/user_form', 'content_data' => ['user' => new AppUser, 'role' => 'team']]); ?>
<script>

    $(document).ready(function () {

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

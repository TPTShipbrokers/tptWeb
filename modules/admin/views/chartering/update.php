<?php

use app\models\AppUser;
use app\models\Claims;
use app\models\Company;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Chartering */

$this->title = 'Update Chartering ';
$this->params['breadcrumbs'][] = ['label' => 'Chartering', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chartering_id, 'url' => ['view', 'id' => $model->chartering_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chartering-update">


    <h1 class="">
        <?= Html::encode($this->title) ?>
    </h1>

    <div class="row">


        <?= $this->render('_form', [
            'model' => $model,
            'vessels' => $vessels,
            'statuses' => $statuses,
            'all_clients' => $all_clients,
            'all_companies' => $all_companies,
            'clients' => $clients,
            'companies' => $companies,
            'broker' => $broker,
            'all_team' => $all_team
        ]) ?>

        <div class="clearfix"></div>
    </div>


    <?= $this->render('/modal-template', ['id' => 'newClientModal', 'title' => 'User Details', 'subtitle' => 'create account', 'content_template' => 'users/user_form', 'content_data' => ['user' => new AppUser, 'role' => 'client']]); ?>
    <?= $this->render('/modal-template', ['id' => 'newBrokerModal', 'title' => 'User Details', 'subtitle' => 'create account', 'content_template' => 'users/user_form', 'content_data' => ['user' => new AppUser, 'role' => 'team']]); ?>
    <?= $this->render('/modal-template', ['id' => 'newCompanyModal', 'title' => 'New Company', 'subtitle' => 'create account', 'content_template' => 'companies/create-form', 'content_data' => ['model' => new Company]]); ?>


    <?= $this->render('/modal-template', ['id' => 'newStatusModal', 'title' => 'Change status', 'subtitle' => 'set operation status', 'content_template' => 'statuses/status_form', 'content_data' => ['chartering_id' => $model->chartering_id, 'date' => null, 'status' => null, 'update' => false]]); ?>
    <?= $this->render('/modal-template', ['id' => 'updateStatusModal', 'title' => 'Update status details', 'subtitle' => ' operation status', 'content_template' => 'statuses/status_form', 'content_data' => ['chartering_id' => $model->chartering_id, 'date' => null, 'status' => null, 'update' => true]]); ?>
    <?= $this->render('/modal-template', ['id' => 'newClaimModal', 'title' => 'Add new claim for chartering', 'subtitle' => ' chartering claims', 'content_template' => 'claims/_form', 'content_data' => ['model' => new Claims, 'chartering_id' => $model->chartering_id]]); ?>
    <?= $this->render('/modal-template', ['id' => 'updateClaimModal', 'title' => 'Update claim for chartering', 'subtitle' => ' chartering claims', 'content_template' => 'claims/_form', 'content_data' => ['model' => null, 'chartering_id' => $model->chartering_id]]); ?>


</div>


<script>

    $(document).ready(function () {

        Main.init();
        initStatusForm('new');

        $('#newClientModal form, #newBrokerModal form').submit(function () {

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

                            if (data.data.role == 'client') {
                                toastr.success('User account successfully created. Login instructions have been sent to client.');
                                $("#assignClientForm select").append("<option value='" + data.data.user_id + "' selected>" + data.data.first_name + " " + data.data.last_name + "</option>");
                                $("#newClientModal").modal('hide');
                            } else {
                                toastr.success('Broker account successfully created.');
                                $("#assignBrokerForm select").append("<option value='" + data.data.user_id + "' selected>" + data.data.first_name + " " + data.data.last_name + "</option>");
                                $("#newBrokerModal").modal('hide');
                            }

                            return false;
                        } else {
                            toastr.error(data.data.error_description);
                            return false;

                        }

                        return false;
                    },
                },

            });


            return false;
        });

        Main.initConfirmation('.confirmation-delete', false, {
            "chartering_id": <?=$model->chartering_id?>,
            "action": "delete"
        });
        Main.initConfirmation('.confirmation-delete-claim');

        $('.submit-btn').click(function () {

            $form = $('#operation_form');

            if ($('#operation_form').valid() == false) {
                return false;
            }

            Main.save('#operation_form', '<?=Url::toRoute("chartering/view/" . $model->chartering_id)?>');
        });


        $('.update-status-btn').click(function () {
            //jQuery.noConflict();
            var id = jQuery(this).data('id');
            jQuery.post('<?=Url::toRoute("chartering/status_details/")?>/' + id, {}, function (data) {
                jQuery('#status_form_wrap_update').replaceWith(data);

                jQuery('#updateStatusModal').modal('show');
                initStatusForm('update');
            });
        });

        Main.initDatetimePicker(".form_datetime_status");

        jQuery('.update-claim-btn').on('click', function () {


            $url = jQuery(this).data('url');
            console.log($url);
            $data = {chartering_id: <?=$model->chartering_id?>};
            jQuery.post($url, $data, function (data) {

                jQuery('#updateClaimModal').modal('show');
                jQuery('#updateClaimModal .claims-form').replaceWith(data);
            });
        });
    });

    function submitClaimForm(el_id, id) {

        $.noConflict();
        $ = jQuery;

        if (id > 0)
            $id = id;
        else
            $id = '';

        $form = $(el_id);
        $url = $form.attr('action');
        $data = new FormData(document.querySelector(el_id));

        $.ajax({
            url: $form.attr('action'),
            type: "POST",
            data: $data,
            contentType: false,
            cache: false,
            processData: false,


        }).done(function (data) {
            console.log('done');

            if (data.result == 'error') {
                toastr.error(data.data.error_description);
            } else {


                toastr.success('Details successfully saved.');
                $('#newClaimModal').modal('hide');
                $('#updateClaimModal').modal('hide');
                Main.initConfirmation('.confirmation-delete-claim');


                if ($('#claim_row' + $id).length) {
                    $('#claim_row' + $id).replaceWith(data);
                } else {
                    $('#claims-container .empty').remove();
                    $('#claims-container').prepend(data);

                }

                $('.update-claim-btn').on('click', function () {

                    $url = $(this).data('url');
                    console.log($url);
                    $data = {chartering_id: <?=$model->chartering_id?>};
                    $.post($url, $data, function (data) {

                        $('#updateClaimModal').modal('show');
                        $('#updateClaimModal .claims-form').replaceWith(data);

                    });


                });
            }


            return false;

        }).fail(function () {
            toastr.error('An error occurred');
        });


    }

    var assignNewCompany = function (data) {

        $("#assignCompanyForm select").append("<option value='" + data.data.company_id + "' selected>" + data.data.company_name + "</option>");
        $("#newCompanyModal").modal('hide');
        return false;
    }

    function save(id, callback) {
        Main.save(id, null, assignNewCompany);
    }

    function initStatusForm(type) {

        Main.initDatetimePicker(".form_datetime_status");

        $('#status_form_wrap_' + type + ' .set-btn').click(function () {
            Main.save('#status_form_' + type, null, function () {
                toastr.success('Chartering status successfully set.');
                setTimeout(function () {
                    location.reload(1);
                }, 3000);
            });
        });

        var statuses = [
            <?php foreach($all_statuses as $status): ?>
            {num: "<?=$status->description?>", id: <?=$status->status_id?>  },
            <?php endforeach; ?>
        ];

        Main.initTypeahead('#typeahead_status', statuses, '#typeahead_status_id');

    }


</script>

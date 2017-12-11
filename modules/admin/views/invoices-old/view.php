<?php

use yii\helpers\Url;


?>


<h3 class="page-title"> Invoice
    <small>view invoice</small>
</h3>


<div class="invoice">
    <div class="row invoice-logo">
        <div class="col-xs-6 invoice-logo-space">
            <img src="<?= Yii::$app->request->baseUrl . '/assets/pages/media/invoice/invoice_logo.png' ?>"
                 class="img-responsive" alt=""/></div>
        <div class="col-xs-6">
            <p> #<?= $model->invoice_id ?> / <?= date('d M Y', strtotime($model->date)) ?>
                <span class="muted">  </span>
            </p>
        </div>
    </div>
    <hr/>
    <?php
    $operation = $model->getOperation();
    if ($operation):
        ?>
        <div class="row">
            <div class="col-md-5">
                <h3>Client:</h3>
                <ul class="list-unstyled">
                    <?php $client = $operation->user; ?>
                    <li> <?= $client->first_name . ' ' . $client->last_name ?> </li>
                    <li><a href="mailto: <?= $client->email ?>"><?= $client->email ?></a></li>
                    <li><a href="tel: <?= $client->email ?>"><?= $client->phone ?></a></li>

                </ul>
            </div>
            <div class="col-md-5 invoice-payment">
                <h3>Operation Details:</h3>
                <ul class="list-unstyled">
                    <?php $operation = $model->operation; ?>
                    <li>
                        <strong>Reference ID:</strong>
                        <span class="pull-right text-left">#<?= $operation->reference_id ?> </span>
                    </li>
                    <li>
                        <strong>Discharging/Receiving vessels:</strong>
                        <span class="pull-right">
                    	<?= $operation->dischargingShip->name ?>-<?= $operation->receivingShip->name ?> 
                    </span>
                    </li>
                    <li>
                        <strong>Location:</strong>
                        <span class="pull-right"><?= $operation->location->title ?> </span>
                    </li>
                    <li>
                        <strong>End Time:</strong>
                        <span class="pull-right">
                    	<?= date('d M Y', strtotime($operation->end_time)) ?> 
                    </span>
                    </li>
                    <?php if ($operation->report): ?>
                        <li class="hide-print">
                            <strong>Post Operation Report:</strong>
                            <span class="pull-right">
	                    <a href="<?= Yii::$app->request->baseUrl . '/' . $operation->report->file ?>" target="_blank"
                           class="btn btn-sm blue btn-outline">View Document</a>
	                </span>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>


        </div>

    <?php else: ?>
        <div class="alert alert-danger hide-print alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <b> Operation not assigned! </b>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th> #</th>
                    <th class="hidden-xs"> DESCRIPTION</th>
                    <th class="hidden-xs"> RATE/DAY</th>
                    <th class="hidden-xs"> NO DAYS</th>
                    <th> TOTAL AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->getInvoiceItems()->all() as $i => $item): ?>
                    <tr>
                        <td> <?= $i + 1 ?> </td>
                        <td> <?= $item->description ?> </td>
                        <td class="hidden-xs"> <?= $item->rate_per_day == null ? "NA" : $item->rate_per_day ?> </td>
                        <td class="hidden-xs"> <?= $item->days_no == null ? "NA" : $item->days_no ?> </td>

                        <td> $<?= $item->amount ?> </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 ">
            <ul class="list-unstyled amounts">
                <li>
                    <strong>Total:</strong> <span class="pull-right">$<?= $model->total ?></span></li>
                <li>
                    <strong>Less:</strong> <span class="pull-right"><?= $model->less ?> </span></li>

                <li>
                    <strong>Net Total:</strong> <span class="pull-right">$<?= $model->net_amount ?> </span></li>
            </ul>
            <br/>

        </div>
        <div class="col-md-4 col-md-offset-4 col-xs-4 col-sm-4 col-sm-offset-0 col-xs-offset-0">
            <div class="well">
                <address>
                    <strong>Top Fenders Limited</strong>
                    <br> 5 Welbeck Street, Ground Floor
                    <br> London, W1G 9YQ, United Kingdom
                    <br>
                    <abbr title="Phone">T:</abbr> +44(0) 203 219 5780 <br>
                    <abbr title="Fax">F:</abbr> +44(0) 203 219 5788 <br>
                    <abbr title="Fax">E:</abbr><a href="mailto:sts@topfenders.com"> sts@topfenders.com </a> <br>
                </address>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-2 text-left">
            <a class="btn btn-lg red hidden-print margin-bottom-5"
               href="<?= Url::toRoute('invoices/update/' . $model->invoice_id) ?>">
                <i class="fa fa-edit"></i> Update
            </a>
        </div>
        <div class="col-xs-10 text-right">

            <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                <i class="fa fa-print"></i>
            </a>

            <a class="btn btn-lg green hidden-print margin-bottom-5" data-target="#modal_operation_1"
               data-toggle="modal"> Send Invoice
                <i class="fa fa-check"></i>
            </a>

        </div>
    </div>
</div>

<div id="modal_operation_1" class="modal fade large" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Send Invoice</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="control-label col-md-4">Email</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" value="" id="email_input"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4">Subject</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="subject_input"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn green" data-dismiss="modal"
                        onclick="sendInvoice(<?= $model->invoice_id ?>, '<?= Url::toRoute('invoices/send_email') ?>')">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    function sendInvoice($id, $url) {

        $email = $('#email_input').val();
        $subject = $('#subject_input').val();

        $.post($url, {invoice_id: $id, email: $email, subject: $subject}, function (data) {

            if (data.result == 'success') {
                toastr.success('Email successfully sent.');
                $('#email_input').val('');
                $('#subject_input').val('');
            } else {
                toastr.error(data.data);
            }
        });
    }

</script>
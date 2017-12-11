<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = $model->invoice_id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h3 class="page-title"> Invoice
    <small>view invoice</small>
</h3>


<div class="invoice">
    <div class="row invoice-logo">
        <div class="col-xs-6 invoice-logo-space">
            <img src="<?= Yii::$app->request->baseUrl . '/assets/pages/media/invoice/tpt_logo.png' ?>"
                 class="img-responsive" alt=""/></div>
        <div class="col-xs-6">


        </div>
    </div>
    <hr/>
    <p> #<?= $model->invoice_id ?> / <span class="label label-danger"
                                           style="display: inline">Due date:<?= date('d M Y', strtotime($model->due_date)) ?></span>
    </p>

    <div class="row">

        <div class="col-xs-4">
            <b> Invoice: </b>

        </div>
        <div class="col-xs-8">

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-4">
            <b> Vessel: </b>

        </div>
        <div class="col-xs-8">

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-4">
            <b> Fixture ref.: </b>

        </div>
        <div class="col-xs-8">

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-4">
            <b> Reference: </b>

        </div>
        <div class="col-xs-8">

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-4">
            <b> CP Date: </b>

        </div>
        <div class="col-xs-8">

        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <?php
    $chartering = $model->chartering;
    if ($chartering):
        ?>
        <div class="row">

            <div class="col-md-6 invoice-payment">
                <h3>Chartering Details:</h3>
                <?= $this->render('/chartering/details', ['model' => $model->chartering]) ?>
            </div>
            <div class="col-md-6">
                <h3>Invoice PDF:</h3>

                <div id="ship_doc_row">
                    <a class="btn btn-sm grey-salsa btn-outline"
                       href="#ship_doc_<?= $model->filename ?>"
                       data-toggle="collapse"
                       target="_blank"
                       class="btn green  btn-outline accordion-toggle collapsed" aria-expanded="false"
                    >
                        <?= $model->filename ? $model->filename : "View Document" ?>
                    </a>
                </div>

                <?php /*foreach($model->invoiceDocumentations as $doc): ?>
                <div id="ship_doc_row<?=$doc->invoice_documentation_id?>">
                    <a class="btn btn-sm grey-salsa btn-outline"
                       href="#ship_doc_<?=$doc->invoice_documentation_id?>"
                       data-toggle="collapse"
                       target="_blank"
                       class="btn green  btn-outline accordion-toggle collapsed"  aria-expanded="false"
                    >
                        <?=$doc->filename?$doc->filename:"View Document"?>
                    </a>
                    <p id="ship_doc_<?=$doc->invoice_documentation_id?>"
                       class="panel-collapse collapse"
                       aria-expanded="false"
                    >
                        <a class="btn btn-success" href="<?=Yii::$app->request->baseUrl . '/' . $doc->file?>"
                           target="_blank"> View document
                        </a>
                    </p>
                </div>
            <?php endforeach;*/ ?>
                <h3>Status:</h3>
                <?php $statuses = ['pending' => 'info', 'paid' => 'success', 'overdue' => 'danger']; ?>
                <div class="well">
                    <span class="label label-<?= $statuses[$model->status] ?>"><?= $model->status ?> </span>
                </div>
            </div>


        </div>

    <?php else: ?>
        <div class="alert alert-danger hide-print alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <b> Chartering not assigned! </b>
        </div>
    <?php endif; ?>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-unstyled amounts">
                <li>
                    <strong>Freight:</strong> <span class="pull-right"><?= $model->freight ?> </span>
                </li>
                <li>
                    <strong>Commission percentage:</strong> <span
                            class="pull-right"><?= $model->commission_percentage ?> </span>
                </li>
                <li>
                    <strong>VAT:</strong> <span class="pull-right"><?= $model->VAT ?> </span>
                </li>
                <li></li>
                <li>
                    <strong>Total:</strong> <span class="pull-right">$<?= $model->total ?></span>
                </li>

            </ul>
            <br/>

        </div>

        <div class="col-md-4 col-md-offset-4 col-xs-4 col-sm-4 col-sm-offset-0 col-xs-offset-0">
            <div class="well">
                <address>
                    <strong>Tune Product Tankers B.V.</strong>
                    <br> Burg. v/d Jagtkade 10
                    <br> 3221 CB Hellevoetsluis
                    <br>
                    <br>
                    <strong>Mail address:</strong>
                    <br> P.O. Box 170
                    <br> 3220 AD Hellevoetsluis
                    <br>
                    <br>
                    <abbr title="Phone">T:</abbr> +31-(0)181-330055 <br>

                    <abbr title="Fax">F:</abbr> +31-(0)181-396669 <br>
                    <abbr title="Fax">E:</abbr><a href="mailto:claims@tunept.com"> claims@tunept.com </a> <br>
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

            <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="window.print();"> Print
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

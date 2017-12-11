<?php

namespace app\modules\admin\controllers;

use app\models\Invoice;
use app\models\InvoiceItem;
use app\models\Location;
use app\models\Operation;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;


class InvoicesController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'column2';

    public function beforeAction($action)
    {
        if (\Yii::$app->getModule('admin')->user->isGuest) {
            $this->redirect(Url::toRoute('login/'));
        }

        if (!parent::beforeAction($action)) return false;

        return true;
    }

    public function actionIndex()
    {

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['invoices' => Invoice::find()->all()]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }

    }

    public function actionView($id)
    {
        $model = Invoice::findOne($id);

        return $this->render('view', ['model' => $model]);
    }

    public function actionCreate($id = null)
    {
        $model = new Invoice;
        $operation = null;

        if ($id) {
            $operation = Operation::findOne($id);

            Yii::$app->utils->checkExistence($operation);
        }

        return $this->processInvoice($model, $operation);
    }

    public function processInvoice($model, $assigned_operation = null)
    {

        $post = Yii::$app->request->post();

        if (isset($post['Invoice'])) {

            $old_file = $model->file;


            $model->attributes = $post['Invoice'];

            if ($model->less == null) {
                $model->less = 0;
            }


            $file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {


                if ($file) {
                    $file_id = uniqid();
                    $model->file = 'uploads/documents/' . $file->baseName . $file_id . '.' . $file->extension;
                    $file->saveAs('uploads/documents/' . $file->baseName . $file_id . '.' . $file->extension);
                } else {
                    $model->file = $old_file;
                }

                $model->save();

                if (isset($post['Invoice']['operation_id'])) {

                    $old_operation = Operation::find()->where(['invoice_id' => $model->invoice_id])->one();

                    if ($old_operation) {

                        $old_operation->invoice_id = null;

                        $r = $old_operation->trySave(true);

                        if ($r['result'] != 'success') {
                            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($operation->getErrors())], false);
                        }
                    }


                    $operation = Operation::findOne($post['Invoice']['operation_id']);
                    $operation->invoice_id = $model->invoice_id;
                    $r = $operation->trySave(true);

                    if ($r['result'] != 'success') {
                        return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($operation->getErrors())], false);
                    }

                }


                if (isset($post['InvoiceItem'])) {
                    foreach ($post['InvoiceItem'] as $item) {
                        $m = new InvoiceItem;
                        $m->amount = $item['amount'];
                        $m->description = $item['description'];
                        $m->rate_per_day = !empty($item['rpd']) ? $item['rpd'] : null;
                        $m->days_no = !empty($item['days_no']) ? $item['days_no'] : null;
                        $m->invoice_id = $model->invoice_id;

                        $r = $m->trySave(true);

                        if ($r['result'] != 'success') {
                            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($m->getErrors())], false);
                        }


                    }
                }

            } else {
                return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }

            return $this->redirect(Yii::$app->request->baseUrl . '/admin/invoices');

        } else {


            return $this->render('create', ['model' => $model, 'operations' => Operation::find()->all(), 'assigned_operation' => $assigned_operation]);
        }
    }

    public function actionSend_email()
    {
        $post = Yii::$app->request->post();

        if (isset($post['invoice_id'])) {
            $model = Invoice::findOne($post['invoice_id']);
            Yii::$app->utils->checkExistence($model);


            $to = $post['email'];
            $subject = $post['subject'];

            if ($model->file) {
                $att = file_get_contents($model->file);
                $att = base64_encode($att);
                $att = chunk_split($att);
            }

            $filename = basename($model->file);


            $BOUNDARY = "anystring";

            $headers = <<<END
From: TopFenders <admin@topfenders.com>
Content-Type: multipart/mixed; boundary=$BOUNDARY
END;

            $body = <<<END
--$BOUNDARY
Content-Type: text/plain

--$BOUNDARY
Content-Type: application/pdf
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="$filename"

$att
--$BOUNDARY--
END;

            if (!$model->file) {

                return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid data', 'error_description' => 'Invoice doesn\'t have file attached.'], false);

            }


            mail($to, $subject, $body, $headers);

            Yii::$app->api->_sendResponse(200);
        }
    }


    public function actionCreate_invoice_item()
    {

    }

    public function actionUpdate($id)
    {
        $model = Invoice::findOne($id);
        return $this->processInvoice($model);
    }

    public function actionOperation_details($id)
    {
        $model = Operation::findOne($id);
        Yii::$app->utils->checkExistence($model);
        $data = Operation::format($model, ['user' => true, 'report' => true], false);

        return Yii::$app->api->_sendResponse(200, $data, true);


    }

    public function actionDelete_item($id = null)
    {

        $post = Yii::$app->request->post();
        $model = InvoiceItem::findOne($id);
        Yii::$app->utils->checkExistence($model);

        $model->tryDelete();
    }

    public function actionDelete()
    {

        $post = Yii::$app->request->post();

        $model = Invoice::findOne($post['invoice_id']);

        if ($model != null) {

            $items = $model->getInvoiceItems()->all();

            foreach ($items as $item) {
                if (!$item->delete()) {
                    return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_keys($item->getErrors())], false);
                }
            }

            if (!$model->delete()) {
                return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_keys($model->getErrors())], false);
            } else {
                return Yii::$app->api->_sendResponse(200);
            }


        } else {

            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Invoice with supplied id does not exist.'], false);

        }
    }


}

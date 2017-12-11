<?php

namespace app\modules\admin\controllers;

use app\models\Chartering;
use app\models\Invoice;
use app\models\InvoicesSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url as Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * InvoicesController implements the CRUD actions for Invoice model.
 */
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


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($post = Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->load($post);

                if (!isset($post['Invoice']['status']) || !$post['Invoice']['status'])
                    $model->status = 'pending';

                $chartering = Chartering::findOne($post['Invoice']['chartering_id']);

                if ($chartering)
                    $model->vessel_id = $chartering->vessel_id;

                if ($model->save()) {

                    $doc = UploadedFile::getInstance($model, 'invoice_documentations');

                    if ($doc) {
                        $uid = uniqid();
                        $model->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                        $model->filename = $doc->baseName . '.' . $doc->extension;
                        $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);

                        $model->save();
                    }

                    /*if (!empty($documentations)){
                        foreach($documentations as $doc){
                            $uid = uniqid();
                            $modelDoc = new InvoiceDocumentations();
                            $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                            $modelDoc->invoice_id = $model->invoice_id;
                            $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                            $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                            $modelDoc->save();
                        }
                    }*/

                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->invoice_id]);
                } else
                    $transaction->rollBack();

            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->render('/notification', ['class' => 'danger', 'message' => $e->getMessage()]);

            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($post = Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->load($post);

                if ($model->save()) {

                    $doc = UploadedFile::getInstance($model, 'invoice_documentations');

                    if ($doc) {
                        $uid = uniqid();
                        $model->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                        $model->filename = $doc->baseName . '.' . $doc->extension;
                        $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);

                        $model->save();
                    }

                    /*$oldDocs = $model->invoiceDocumentations;

                    foreach($oldDocs as $doc) {
                        if (file_exists($doc->file)){
                            unlink($doc->file);
                        }
                        $doc->delete();
                    }

                    foreach($documentations as $doc){
                        $uid = uniqid();
                        $modelDoc = new InvoiceDocumentations();
                        $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                        $modelDoc->invoice_id = $model->invoice_id;
                        $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                        $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                        $modelDoc->save();
                    }
                    */

                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->invoice_id]);
                } else
                    $transaction->rollback();

            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->render('/notification', ['class' => 'danger', 'message' => $e->getMessage()]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->file && file_exists($model->file)) {
            unlink($model->file);
        }
        $model->tryDelete();

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
From: TPT <admin@tunept.com>
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


}

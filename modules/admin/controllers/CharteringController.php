<?php

namespace app\modules\admin\controllers;

use app\components\PositionHelper;
use app\models\AppUser;
use app\models\Chartering;
use app\models\CharteringClient;
use app\models\CharteringCompany;
use app\models\CharteringSearch;
use app\models\CharteringStatuses;
use app\models\CharterParty;
use app\models\Company;
use app\models\Invoice;
use app\models\InvoiceDocumentations;
use app\models\ShipDocumentations;
use app\models\Status;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url as Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CharteringController implements the CRUD actions for Chartering model.
 *
 * comment
 */
class CharteringController extends Controller
{
    public $layout = 'column2';
    public $enableCsrfValidation = false;

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
                    'remove_client' => ['post'],
                    'remove_company' => ['post'],
                    'update_status' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Chartering models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharteringSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chartering model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);


        $query = Invoice::find()->where(['chartering_id' => $model->chartering_id]);
        $invoices = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'all_statuses' => Status::find()->all(),
            'completed' => $model->state == 'completed',
            'invoices' => $invoices
        ]);
    }

    /**
     * Finds the Chartering model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Chartering the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chartering::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Chartering model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chartering();

        if ($post = Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($post['vessel_name']) {
                    $model->vessel_name = $post['vessel_name'];
                } else {
                    return $this->render('/notification', ['class' => 'danger', 'message' => 'Tanker incorrect']);
                }

                $model->subs_due = isset($post['Chartering']['subs_due']) ? $post['Chartering']['subs_due'] : null;
                $model->sof_comments = isset($post['Chartering']['sof_comments']) ? $post['Chartering']['sof_comments'] : null;

                if (isset($post['Chartering']['state']))
                    $model->state = $post['Chartering']['state'];


                $ship_documentations = UploadedFile::getInstances($model, 'ship_documentations');

                $model->broker_id = $post['broker_id'];

                $res = $model->trySave(true);


                if ($res['result'] != 'success') {
                    return $this->render('/notification', ['class' => 'danger', 'message' => $res['data']['error_description']]);
                } else {

                    if (!empty($ship_documentations)) {
                        foreach ($ship_documentations as $doc) {
                            $uid = uniqid();
                            $modelDoc = new ShipDocumentations;

                            $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                            $modelDoc->chartering_id = $model->chartering_id;
                            $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                            $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                            $modelDoc->trySaveGeneral($transaction);
                        }
                    }
                }

                $relations = [
                    'Clients' => ['model' => AppUser::className(), 'relationModel' => CharteringClient::className(), 'pk' => 'client_id'],
                    'Companies' => ['model' => Company::className(), 'relationModel' => CharteringCompany::className(), 'pk' => 'company_id'],
                ];

                foreach ($relations as $name => $data) {
                    if (!isset($post[$name]))
                        continue;

                    $ids = $post[$name];

                    foreach ($ids as $rel_id) {

                        if ($name == 'Clients') {
                            $exists = AppUser::find()->where(['user_id' => $rel_id, 'role' => 'client'])->one();
                            $assigned = CharteringClient::find()->where(['client_id' => $rel_id, 'chartering_id' => $model->chartering_id])->one();
                        } else {
                            $exists = Company::find()->where(['company_id' => $rel_id])->one();
                            $assigned = CharteringCompany::find()->where(['company_id' => $rel_id, 'chartering_id' => $model->chartering_id])->one();
                        }


                        if ($exists && !$assigned) {

                            $relation = new $data['relationModel'];
                            $relation->{$data['pk']} = $rel_id;
                            $relation->chartering_id = $model->chartering_id;

                            if (isset($post['scheduled']) && $post['scheduled'] == 1 && $data['relationModel'] == CharteringClient::className()) {
                                $relation->status = 'scheduled';
                                $relation->scheduled_date = isset($post['scheduled_date']) ? $post['scheduled_date'] : null;
                            }

                            $res = $relation->trySaveGeneral();

                        } else if (!$exists) {
                            // return Yii::$app->api->_sendResponse(200, ['error'=>'Invalid Data', 'error_description' => 'ID is not valid.'], false);
                            $this->render('/notification', ['class' => 'danger', 'message' => 'ID is not valid.']);
                        }
                    }
                }

                $transaction->commit();

                return $this->redirect(['view', 'id' => $model->chartering_id]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->render('/notification', ['class' => 'danger', 'message' => $e->getMessage()]);

            }
        } else {
            /** @var PositionHelper $positionHelper */
            $positionHelper = Yii::$app->get('positionHelper');

            return $this->render('create', [
                'model' => $model,
                'vessels' => $positionHelper->getVesselNames(),
                'statuses' => ArrayHelper::map(Status::find()->all(), 'status_id', 'description'),
                'all_clients' => AppUser::format(AppUser::find()->where(['role' => 'client'])->all(), ['full_name' => true], false),
                'all_companies' => Company::find()->asArray()->all(),
                'all_team' => AppUser::format(AppUser::find()->where(['role' => 'team'])->all(), ['full_name' => true], false),
                'broker' => []
            ]);
        }
    }

    /**
     * Updates an existing Chartering model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Chartering::findOne($id);
        $old_subs_due = $model->subs_due;

        if ($post = Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($post['vessel_name']) {
                    $model->vessel_name = $post['vessel_name'];
                } else {
                    return $this->render('/notification', ['class' => 'danger', 'message' => 'Tanker incorrect']);
                }

                $model->subs_due = isset($post['Chartering']['subs_due']) ? $post['Chartering']['subs_due'] : $model->subs_due;
                $model->sof_comments = isset($post['Chartering']['sof_comments']) ? $post['Chartering']['sof_comments'] : $model->sof_comments;

                if (isset($post['Chartering']['state']))
                    $model->state = $post['Chartering']['state'];

                if (isset($post['Chartering']['locked']))
                    $model->locked = $post['Chartering']['locked'];


                if (isset($post['CharterParty'])) {
                    $charterParty = $model->charterParty ? $model->charterParty : new CharterParty;

                    $charterParty->description = $post['CharterParty']['description'];
                    $charterParty->datetime = $post['CharterParty']['datetime'];

                    $charterParty->trySaveGeneral();

                    $model->charter_party = $charterParty->charter_party_id;
                }

                $relations = [
                    'Clients' => ['model' => AppUser::className(), 'relationModel' => CharteringClient::className(), 'pk' => 'client_id'],
                    'Companies' => ['model' => Company::className(), 'relationModel' => CharteringCompany::className(), 'pk' => 'company_id'],
                ];

                foreach ($relations as $name => $data) {
                    if (!isset($post[$name]))
                        continue;

                    $ids = $post[$name];

                    foreach ($ids as $rel_id) {

                        if ($name == 'Clients') {
                            $exists = AppUser::find()->where(['user_id' => $rel_id, 'role' => 'client'])->one();
                            $assigned = CharteringClient::find()->where(['client_id' => $rel_id, 'chartering_id' => $id])->one();
                        } else {
                            $exists = Company::find()->where(['company_id' => $rel_id])->one();
                            $assigned = CharteringCompany::find()->where(['company_id' => $rel_id, 'chartering_id' => $id])->one();
                        }

                        if ($exists && !$assigned) {

                            $relation = new $data['relationModel'];
                            $relation->{$data['pk']} = $rel_id;
                            $relation->chartering_id = $id;

                            if (isset($post['scheduled']) && $post['scheduled'] == 1 && $data['relationModel'] == CharteringClient::className()) {
                                $relation->status = 'scheduled';
                                $relation->scheduled_date = isset($post['scheduled_date']) ? $post['scheduled_date'] : null;
                            }

                            $res = $relation->trySaveGeneral();

                        } else if (!$exists) {
                            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'ID is not valid.'], false);
                        }
                    }
                }

                $model->broker_id = $post['broker_id'];

                $res = $model->trySave(true);

                if ($res['result'] != 'success') {
                    $transaction->rollBack();
                    $this->render('/notification', ['class' => 'danger', 'message' => $res['data']['error_description']]);
                } else {

                    $ship_documentations = UploadedFile::getInstances($model, 'ship_documentations');
                    if (!empty($ship_documentations)) {

                        $oldDocs = $model->shipDocumentations;

                        /*foreach($oldDocs as $doc){
                          if(file_exists($doc->file)){
                            unlink($doc->file);
                          }
                          $doc->tryDelete($transaction);
                        }*/

                        foreach ($ship_documentations as $doc) {
                            $uid = uniqid();
                            $modelDoc = new ShipDocumentations;

                            $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                            $modelDoc->chartering_id = $model->chartering_id;
                            $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                            $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                            $modelDoc->trySaveGeneral($transaction);
                        }
                    }

                    $invoice_documentations = UploadedFile::getInstances($model, 'invoice_documentations');
                    if (!empty($invoice_documentations)) {

                        $oldDocs = $model->invoiceDocumentations;

                        foreach ($invoice_documentations as $doc) {
                            $uid = uniqid();
                            $modelDoc = new InvoiceDocumentations();

                            $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                            $modelDoc->chartering_id = $model->chartering_id;
                            $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                            $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                            $modelDoc->trySaveGeneral($transaction);
                        }
                    }

                    $transaction->commit();

                    if ($model->subs_due != $old_subs_due) {

                        Yii::$app->utils->createCron($model->subs_due, "cron/subs " . $model->chartering_id, $model->chartering_id);
                    }
                    $this->redirect('../view/' . $model->chartering_id);

                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->render('/notification', ['class' => 'danger', 'message' => $e->getMessage()]);
            }
        } else {
            /*$assigned_clients = AppUser::format(AppUser::find()
                ->where(['role' => 'client'])
                ->andWhere('exists (select * from CharteringClient where chartering_id=:chartering_id and client_id=User.user_id)', [':chartering_id' => $model->chartering_id])->all(), ['full_name' => true], false);
            $assigned_companies = Company::format(Company::find()
                ->where('exists (select * from CharteringCompany where chartering_id=:chartering_id and company_id=Company.company_id)', [':chartering_id' => $id])->all(), [], false);
            */

            /** @var PositionHelper $positionHelper */
            $positionHelper = Yii::$app->get('positionHelper');

            return $this->render('update', [
                'model' => $model,
                'vessels' => $positionHelper->getVesselNames(),
                'statuses' => ArrayHelper::map(Status::find()->all(), 'status_id', 'description'),
                'all_clients' => AppUser::format(AppUser::find()->where('not exists (select * from CharteringClient where chartering_id=:chartering_id and client_id=User.user_id)', [':chartering_id' => $model->chartering_id])->andWhere(['role' => 'client'])->all(), ['full_name' => true], false),
                'all_companies' => Company::find()->where('not exists (select * from CharteringCompany where chartering_id=:chartering_id and company_id=Company.company_id)', [':chartering_id' => $id])->asArray()->all(),
                'companies' => $model->getCharteringCompanies()->all(),
                'clients' => $model->getCharteringClients()->all(),
                'all_statuses' => Status::find()->all(),
                'all_team' => AppUser::format(AppUser::find()->where(['role' => 'team'])->all(), ['full_name' => true], false),
                'broker' => $model->broker_id
            ]);
        }
    }

    public function actionStatus_details($id)
    {
        $model = CharteringStatuses::findOne($id);
        Yii::$app->utils->checkExistence($model);
        return $this->renderPartial('/statuses/status_form', ['chartering_id' => $model->chartering_id, 'status' => $model->status, 'date' => $model->datetime, 'update' => true, 'chartering_status_id' => $model->chartering_status_id]);
    }

    /**
     * Deletes an existing Chartering model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Chartering::findOne($id);
        Yii::$app->utils->checkExistence($model);

        if ($model->shipDocumentations) {
            foreach ($model->shipDocumentations as $doc) {
                if (file_exists($doc->file)) {
                    unlink($doc->file);
                }
            }
        }

        if ($model->invoiceDocumentations) {
            foreach ($model->invoiceDocumentations as $doc) {
                if (file_exists($doc->file)) {
                    unlink($doc->file);
                }
            }
        }

        $model->tryDelete();
    }

    public function actionRemove_company($id)
    {

        $post = Yii::$app->request->post();

        if (isset($post['chartering_id'])) {

            $model = Chartering::findOne($post['chartering_id']);
            Yii::$app->utils->checkExistence($model);

            $company = Company::findOne($id);
            Yii::$app->utils->checkExistence($company);

            $relation = CharteringCompany::find()->where(['chartering_id' => $post['chartering_id'], 'company_id' => $id])->one();
            Yii::$app->utils->checkExistence($relation);

            $relation->tryDelete();

        }
    }

    public function actionRemove_client($id)
    {

        $post = Yii::$app->request->post();

        if (isset($post['chartering_id'])) {

            $model = Chartering::findOne($post['chartering_id']);
            Yii::$app->utils->checkExistence($model);

            $user = AppUser::findOne($id);
            Yii::$app->utils->checkExistence($user);

            $relation = CharteringClient::find()->where(['chartering_id' => $post['chartering_id'], 'client_id' => $id])->one();
            Yii::$app->utils->checkExistence($relation);

            $relation->tryDelete();

        }
    }

    public function actionRemove_ship_documentation($id)
    {
        $post = Yii::$app->request->post();

        if (isset($post['chartering_id'])) {

            $model = Chartering::findOne($post['chartering_id']);
            Yii::$app->utils->checkExistence($model);

            $doc = ShipDocumentations::findOne($id);
            Yii::$app->utils->checkExistence($doc);

            if ($doc->chartering_id != $model->chartering_id) {
                return Yii::$app->api->_sendResponse(200, ["error" => "invalid_operation", "error_description" => "Document not related to the specified chartering."], false);
            }
            $doc->tryDelete();
        }
    }

    public function actionRemove_invoice_documentation($id)
    {
        $post = Yii::$app->request->post();

        if (isset($post['chartering_id'])) {

            $model = Chartering::findOne($post['chartering_id']);
            Yii::$app->utils->checkExistence($model);

            $doc = InvoiceDocumentations::findOne($id);
            Yii::$app->utils->checkExistence($doc);

            if ($doc->chartering_id != $model->chartering_id) {
                return Yii::$app->api->_sendResponse(200, ["error" => "invalid_operation", "error_description" => "Document not related to the specified chartering."], false);
            }

            $doc->tryDelete();
        }
    }

    public function actionUpdate_status($id)
    {
        $post = Yii::$app->request->post();

        $chartering = Chartering::findOne($post['chartering_id']);

        Yii::$app->utils->checkExistence($chartering);

        if (!empty($post)) {
            $action = isset($post['action']) ? $post['action'] : false;


            if ($action == 'delete') {

                if (!isset($post['chartering_id'])) {
                    return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Missing chartering id!']);
                }

                $chartering_status_id = $id;
                $status = CharteringStatuses::find()->where(['chartering_status_id' => $chartering_status_id, 'chartering_id' => $post['chartering_id']])->one();

                if ($status) {

                    $status->delete();

                    $old_status = CharteringStatuses::find()->where(['chartering_id' => $post['chartering_id']])->orderby('chartering_status_id desc')->one();

                    if ($old_status) {
                        $chartering->status_id = $old_status->chartering_status_id;
                    } else {
                        $chartering->status_id = null;
                    }

                    $chartering->trySaveGeneral();

                } else {
                    return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid operation.', 'error_description' => 'Chartering status with specified id not found.'], false);
                }

                return Yii::$app->api->_sendResponse(200);

            } else if ($action == 'new') {


                $status_id = $post['typeahead_status_id'];
                $description = $post['typeahead_status'];

                $status_exists = Status::findOne($status_id);


                if ($status_exists && $status_exists->description == $description) {
                    $chartering_status = new CharteringStatuses;
                    $chartering_status->status_id = $status_id;
                    $chartering_status->chartering_id = $id;
                    $chartering_status->datetime = isset($post['date']) ? $post['date'] : date('Y-m-d H:i:s');
                    // description and prefix and suffix missing

                    $chartering_status->trySave();

                    /* if($chartering_status->validate()){
                       $chartering_status->save();

                    //   $chartering->status_id = $chartering_status->chartering_status_id;
                    //   $chartering->trySaveGeneral();

                       return Yii::$app->api->_sendResponse(200);
                     } else {
                       return Yii::$app->api->_sendResponse(200, ['error'=>'An error occurred  while trying to update chartering status.', 'error_description' =>array_values($chartering_status->getErrors())], false);
                     } */
                } else {

                    $new_status = new Status;
                    $new_status->description = $description;

                    $new_status->trySaveGeneral();

                    $chartering_status = new CharteringStatuses;
                    $chartering_status->status_id = $new_status->status_id;
                    $chartering_status->chartering_id = $id;
                    $chartering_status->datetime = isset($post['date']) ? $post['date'] : date('Y-m-d H:i:s');
                    // description and prefix and suffix missing

                    $chartering_status->trySaveGeneral();

                    $chartering->status_id = $new_status->status_id;

                    $res = $chartering->trySaveGeneral(true);

                    return Yii::$app->api->_sendResponse(200);
                }

            } else {

                $chartering_status = CharteringStatuses::findOne($post['chartering_status_id']);
                $chartering_status->datetime = isset($post['date']) ? $post['date'] : date('Y-m-d H:i:s');

                $chartering_status->trySave();
            }


        }

    }

    public function actionDetails($id)
    {
        $model = Chartering::findOne($id);
        return $this->renderPartial('details', ['model' => $model]);

    }
}

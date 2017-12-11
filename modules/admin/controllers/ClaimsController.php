<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use app\models\ClaimDocumentations;
use app\models\Claims;
use app\models\ClaimsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url as Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ClaimsController implements the CRUD actions for Claims model.
 */
class ClaimsController extends Controller
{

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
                    'details' => ['post'],
                    'create' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Claims models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClaimsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Claims model.
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
     * Finds the Claims model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Claims the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Claims::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Claims model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Claims();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = $model->trySave(true);

                if ($res['result'] != 'success') {
                    $transaction->rollBack();
                    return $this->render('/notification', ['class' => 'danger', 'message' => $res['data']['error_description']]);
                } else {
                    $claim_documentations = UploadedFile::getInstances($model, 'claim_documentations');
                    if (!empty($claim_documentations)) {

                        foreach ($claim_documentations as $doc) {
                            $uid = uniqid();
                            $modelDoc = new ClaimDocumentations();
                            $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                            $modelDoc->claim_id = $model->claim_id;
                            $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                            $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                            $modelDoc->trySaveGeneral($transaction);
                        }
                    }

                    $transaction->commit();
                    return $this->renderPartial('view', ['model' => $model, 'actions' => true]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->render('/notification', ['class' => 'danger', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Updates an existing Claims model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $res = $model->trySave(true);

                if ($res['result'] != 'success') {
                    $transaction->rollBack();
                    return $this->render('/notification', ['class' => 'danger', 'message' => $res['data']['error_description']]);
                } else {
                    $claim_documentations = UploadedFile::getInstances($model, 'claim_documentations');
                    if (!empty($claim_documentations)) {

                        foreach ($claim_documentations as $doc) {
                            $uid = uniqid();
                            $modelDoc = new ClaimDocumentations();
                            $modelDoc->file = 'uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension;
                            $modelDoc->claim_id = $model->claim_id;
                            $modelDoc->filename = $doc->baseName . '.' . $doc->extension;
                            $doc->saveAs('uploads/documents/' . $uid . $doc->baseName . '.' . $doc->extension);
                            $modelDoc->trySaveGeneral($transaction);
                        }
                    }

                    $transaction->commit();

                    $rows = AppUser::find()->joinWith('notificationSettings')
                        ->where(['NotificationSettings.outstanding_claims' => 1])
                        ->andWhere('exists(select * from CharteringClient where client_id=User.user_id and chartering_id=:chartering_id) or exists(select * from CharteringCompany where company_id=User.company_id and chartering_id=:chartering_id)', [':chartering_id' => $model->chartering_id])
                        ->select('user_id, email, User.notification_settings_id')->asArray()->all();
                    $emails = array_map(function ($e) {
                        return $e["email"];
                    }, $rows);

                    //Yii::$app->api->send_push_notification('Claim for chartering ' . $model->chartering->vessel_name . ' updated.', $emails);

                    return $this->renderPartial('view', ['model' => $model, 'actions' => true]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->render('/notification', ['class' => 'danger', 'message' => $e->getMessage()]);
            }
        } else {
            Yii::$app->api->_sendResponse(200, ['error' => 'Invalid data', 'error_description' => 'An error ocurred'], false);
        }
    }

    public function actionDelete($id)
    {
        $model = Claims::findOne($id);
        Yii::$app->utils->checkExistence($model);

        if ($model->claimDocumentations) {
            foreach ($model->claimDocumentations as $doc) {
                if (file_exists($doc->file)) {
                    unlink($doc->file);
                }
            }
        }

        $model->tryDelete();
    }

    public function actionDetails($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        return $this->renderPartial('_form', [
            'model' => $model,
            'chartering_id' => $post['chartering_id']
        ]);
    }

    public function actionRemove_claim_documentation($id)
    {
        $post = Yii::$app->request->post();

        if (isset($post['claim_id'])) {

            $model = Claims::findOne($post['claim_id']);
            Yii::$app->utils->checkExistence($model);

            $doc = ClaimDocumentations::findOne($id);
            Yii::$app->utils->checkExistence($doc);

            if ($doc->claim_id != $model->claim_id) {
                return Yii::$app->api->_sendResponse(200, ["error" => "invalid_operation", "error_description" => "Document not related to the specified chartering."], false);
            }
            $doc->tryDelete();
        }
    }
}

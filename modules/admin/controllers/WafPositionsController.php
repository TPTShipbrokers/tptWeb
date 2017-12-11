<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use app\models\UploadForm;
use app\models\WafPosition;
use app\models\WafPositionSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class WafPositionsController
 * @package app\modules\admin\controllers
 */
class WafPositionsController extends BasePositionsController
{
    /**
     * Lists all Vessel models.
     * @param null $id
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex($id = null)
    {
        $searchModel = new WafPositionSearch();
        $queryParams = Yii::$app->request->queryParams;

        if ($id !== null) {
            $queryParams['WafPositionSearch']['positions_visible'] = $id;
        }

        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => new UploadForm(),
            'sort' => ['attributes' => ['name', 'size', 'built', 'location']]
        ]);
    }

    /**
     * Creates a new Vessel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WafPosition();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $rows = AppUser::find()->joinWith('notificationSettings')
                ->where(['NotificationSettings.live_position_updates' => 1])
                ->select('user_id, email, User.notification_settings_id')
                ->asArray()
                ->all();

            $emails = array_map(function ($e) {
                return $e["email"];
            }, $rows);

            //Yii::$app->api->send_push_notification('Position for ' . $model->name . ' updated.', $emails);

            return $this->redirect(['view', 'id' => $model->vessel_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'all_team' => AppUser::format(AppUser::find()
                    ->where(['role' => 'team'])->all(), ['full_name' => true], false),
            ]);
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpload()
    {

        $post = Yii::$app->request->post();

        $model = new UploadForm();

        if (Yii::$app->request->isPost && !empty($post)) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
                $targetFile = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;

                $data = [];
                $fp = fopen($targetFile, 'rb');

                while (!feof($fp)) {
                    $data[] = fgetcsv($fp);
                }

                $errors = [];
                foreach ($data as $csv_values) {
                    if (empty($csv_values)) {
                        continue;
                    }

                    $vesselName = trim($csv_values[0]);

                    if ($vesselName == 'VESSEL') {
                        continue;
                    }

                    $model = WafPosition::find()->where(['name' => $vesselName])->one();

                    if (!$model) {
                        $model = new WafPosition();
                    }

                    $model->name = $vesselName;
                    // $model->owner = $csv_values[$i+7];
                    $model->built = $csv_values[1];
                    $model->cbm = intval(str_replace(",", "", trim($csv_values[2])));
                    $model->dwt = intval(str_replace(",", "", trim($csv_values[3])));
                    $model->loa = floatval(trim($csv_values[4]));
                    $model->intake = intval(str_replace(",", "", trim($csv_values[5])));
                    $model->status = strtolower(str_replace(" ", "_", trim($csv_values[6])));
                    $model->open_date = date("Y-m-d", strtotime($csv_values[7]));
                    // $model->last_cargo = $csv_values[$i+9];
                    $model->sire = strtolower($csv_values[8]);
                    $model->tema_suitable = strtoupper($csv_values[9]);
                    // $model->tema_suitable = $csv_values[$i+10];
                    $model->comments = $csv_values[10];
                    $model->size = strtolower($csv_values[11]);
                    $model->location = $csv_values[12];
                    $model->last = $csv_values[13];
                    $model->imo = $csv_values[14];
                    $model->hull = $csv_values[15];
                    $model->cabotage = $csv_values[16];
                    $model->nigerian_cab = strtoupper($csv_values[17]);
                    $model->grade = strtolower($csv_values[18]);
                    $res = $model->trySave(true);

                    if ($res['result'] == 'error') {
                        $errors[] = $res['data']['error_description'];
                    }
                }

                /* - [0]=> string(6) "Vessel"
                  --- NOT RELEVANT , not exists in design --- [1]=> string(5) "Owner"
                  - [2]=> string(5) "Built"
                  - [3]=> string(3) "Cbm"
                  - [4]=> string(3) "DWT"
                  - [5]=> string(3) "LOA"
                  - [6]=> string(10) "Intake 6,4"
                  --- ALLOWED STATUSES: Open, On Subs ---- [7]=> string(14) "Current status"
                  --- [8]=> string(4) "Lome"
                   --- NOT RELEVANT , not exists in design --- [9]=> string(10) "Last cargo"
                  - [10]=> string(4) "SIRE"
                  - [11]=> string(4) "Tema"
                   --- NOT RELEVANT , not exists in design --- [12]=> string(6) "Owners"
                  - [13]=> string(8) "Comments"
                  - [14]=> string(11) "Size"
                  - [15]=> string(11) "Location"
                  - [16]=> string(11) "Last"
                  - [17]=> string(11) "Imo"
                  - [18]=> string(11) "Hull"
                  - [19]=> string(11) "Cabotage"
                  - [20]=> string(11) "Nigerian Cab"
                  */

                /*
                  * @property string $vessel_id
                  - * @property string $name
                   * @property string $size
                  - * @property string $built
                   * @property string $status
                  - * @property string $open_date
                   * @property string $location
                  - * @property integer $cbm
                  - * @property integer $dwt
                  - * @property integer $loa
                   * @property string $last
                   * @property integer $imo
                   * @property string $hull
                  - * @property integer $sire
                  - * @property integer $intake
                  - * @property string $tema_suitable
                   * @property string $nigerian_cab
                  - * @property string $comments
                  - * @property string $last_update
                  - * @property string $broker_id

                   */

                $rows = AppUser::find()->joinWith('notificationSettings')
                    ->where(['NotificationSettings.live_position_updates' => 1])
                    ->select('user_id, email, User.notification_settings_id')
                    ->asArray()
                    ->all();

                $emails = array_map(function ($e) {
                    return $e["email"];
                }, $rows);

                //FIXIT
                //Yii::$app->api->send_push_notification('Positions updated.', $emails);

                if (!empty($errors)) {
                    return $this->render('/notification', ['message' => $errors, 'class' => 'danger']);
                }

                return $this->redirect('index');
            } else
                return $this->render('/notification', ['message' => array_values($model->getErrors()), 'class' => 'danger']);
        } else
            return $this->render('/notification', ['message' => 'An error occured while trying to parse document.', 'class' => 'danger']);
    }

    /**
     * @return mixed
     */
    public function actionDelete_all()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            /** @var WafPosition[] $vessels */
            $vessels = WafPosition::find()->all();
            foreach ($vessels as $vessel) {
                $vessel->tryDeleteGeneral($transaction);
            }

            $transaction->commit();
            return Yii::$app->api->_sendResponse(200);

        } catch (\Exception $e) {
            $transaction->rollBack();
            return Yii::$app->api->_sendResponse(200, [
                'error' => 'Transaction exception error',
                'error_description' => $e->getMessage()
            ], false);
        }
    }

    /**
     * Finds the WafPosition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WafPosition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WafPosition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

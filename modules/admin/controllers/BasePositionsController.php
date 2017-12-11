<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class BasePositionsController
 * @package app\modules\admin\controllers
 */
abstract class BasePositionsController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'column2';

    /**
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->redirect(Url::toRoute('login/'));
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'upload' => ['post'],
                    'delete_selected' => ['post']

                ],
            ],
        ];
    }

    /**
     * Displays a single Vessel model.
     * @param string $id
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    abstract protected function findModel($id);

    /**
     * Updates an existing Vessel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->broker_id = isset($post['broker_id']) ? $post['broker_id'] : null;

            if ($model->save()) {
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
            }
        }

        if (!Yii::$app->request->isAjax) {
            return $this->render('update', [
                'model' => $model,
                'all_team' => AppUser::format(AppUser::find()->where(['role' => 'team'])->all(), ['full_name' => true], false)
            ]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'all_team' => AppUser::format(AppUser::find()->where(['role' => 'team'])->all(), ['full_name' => true], false)
            ]);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$model = $this->findModel($id);
        //$chartering = chartering::find()->where(['vessel_id' => $model->vessel_id])->one();

        //if($chartering){
        //    return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid operation',
        //        'error_description' => 'Vessel can not be deleted because it is related to chartering. <a href="'. Url::toRoute('chartering/view/' . $chartering->chartering_id) . '" target="_blank" class="label label-danger"> View chartering details </a>'], false);
        //}
        return $this->findModel($id)->tryDelete();
    }

    /**
     * @return mixed
     */
    public function actionDelete_selected()
    {
        $post = Yii::$app->request->post();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($post['ids'] as $id)
                $this->findModel($id)->tryDeleteGeneral($transaction);

            $transaction->commit();
            return Yii::$app->api->_sendResponse(200);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return Yii::$app->api->_sendResponse(200, ['error' => 'Transaction exception error', 'error_description' => $e->getMessage()], false);
        }
    }
}
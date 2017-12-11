<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use app\models\Chartering;
use app\models\CharteringClient;
use app\models\Company;
use app\models\NotificationSettings;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;


class UsersController extends Controller
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
        $data = ['users' => AppUser::find()->all()];

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        //$this->layout = 'column2';
        $user = AppUser::findOne($id);

        return $this->render('view',
            [
                'model' => $user,
                'ongoing_chartering' => $user->getChartering()->all(),
                'past_chartering' => $user->getChartering(true)->all(),
                'charterings' => Chartering::format(Chartering::find()
                    ->where('not exists(select * from CharteringClient where client_id=:client_id and chartering_id=Chartering.chartering_id)', [':client_id' => $id])
                    ->all(), ['title' => true], false),
                'companies' => Company::format(Company::find()->all(), [], false)
            ]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new AppUser;

        $post = Yii::$app->request->post();

        if (isset($post['AppUser'])) {

            $model->attributes = $post['AppUser'];
            $password = Yii::$app->utils->generatePassword(9, true);
            $model->password = sha1($password);

            $image = UploadedFile::getInstance($model, 'profile_picture');

            $notification_settings = new NotificationSettings;

            $r = $notification_settings->trySave(true);

            $model->notification_settings_id = $notification_settings->notification_settings_id;
            $model->market_report_access_level = $post['AppUser']['market_report_access_level'];

            if ($r['result'] != 'success') {
                return Yii::$app->api->_sendResponse(200, $r['data'], false);
            }


            if ($model->validate()) {

                if ($image) {
                    $imageName = uniqid();
                    $model->profile_picture = 'uploads/images/' . $imageName . '.' . $image->extension;
                    $image->saveAs('uploads/images/' . $imageName . '.' . $image->extension);
                }

                $model->save();

                $time = time();
                $hash = sha1($time . '-' . $model->password);

                $url = Url::toRoute('reset_password/' . $hash . '/' . $model->user_id, true);

                Yii::$app->mailer->compose('new-account-email-view', [
                    "url" => $url,
                    "email" => $model->email,
                    "password" => $password])
                    ->setFrom('admin@tunept.com')
                    ->setTo($model->email)
                    ->setSubject("Your account for TPT App has been created")
                    ->send();

                //return $this->redirect(Yii::$app->request->baseUrl . '/admin/users');
                Yii::$app->api->_sendResponse(200, ["user_id" => $model->user_id, "first_name" => $model->first_name, "last_name" => $model->last_name, "role" => $model->role], true);

            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }

        } else {
            return $this->render('create', ['model' => $model]);
        }
    }

    public function actionUpdate($id)
    {
        $model = AppUser::findOne($id);
        $post = Yii::$app->request->post();

        if (isset($post['AppUser'])) {

            $model->attributes = $post['AppUser'];


            if (isset($post['AppUser']['password']) && !empty($post['AppUser']['password'])) {
                $model->password = sha1($post['AppUser']['password']);
            }


            $image = UploadedFile::getInstance($model, 'profile_picture');
            // $model->market_report_access_level = (int)$post['AppUser']['market_report_access_level'];
            // die(var_dump($model));

            if ($model->validate()) {

                if ($image) {
                    $imageName = uniqid();
                    $model->profile_picture = 'uploads/images/' . $imageName . '.' . $image->extension;
                    $image->saveAs('uploads/images/' . $imageName . '.' . $image->extension);
                }
                $model->save();
                return $this->redirect(Yii::$app->request->baseUrl . '/admin/users/view/' . $model->user_id);
            } else {
                return $this->render('/notification', ['class' => 'danger', 'message' => 'An error occurred while trying to update account details.']);
            }
        }
    }

    public function actionDelete($id)
    {

        $model = AppUser::findOne($id);
        Yii::$app->utils->checkExistence($model);
        $model->tryDelete();

    }

    public function actionAssign_company($id)
    {
        $user = AppUser::findOne($id);
        Yii::$app->utils->checkExistence($user);

        $post = Yii::$app->request->post();

        if (isset($post['company_id'])) {

            $company = Company::findOne($post['company_id']);
            Yii::$app->utils->checkExistence($company);
            $user->company_id = $post['company_id'];
            $user->trySaveGeneral();


            Yii::$app->api->_sendResponse(200);
        }
    }

    public function actionAssign_chartering($id)
    {

        $user = AppUser::findOne($id);
        Yii::$app->utils->checkExistence($user);

        $post = Yii::$app->request->post();

        if (isset($post['Chartering']) && !empty($post['Chartering'])) {

            $chartering = !is_array($post['Chartering']) ? [$post['Chartering']] : $post['Chartering'];
            $status = isset($post['Status']) ? $post['Status'] : 'active';

            foreach ($chartering as $chartering_id) {
                $existing = CharteringClient::find()->where(['client_id' => $id, 'chartering_id' => $chartering_id])->one();

                if ($existing) {
                    return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => 'Chartering already assigned to user.'], false);
                }

                $model = new CharteringClient;
                $model->client_id = $user->user_id;
                $model->chartering_id = $chartering_id;
                $model->status = $status;

                $res = $model->trySaveGeneral();

            }

            return Yii::$app->api->_sendResponse(200);
        }


    }

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

    /**
     * Finds the Vessel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AppUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = AppUser::findOne($id);
        Yii::$app->utils->checkExistence($model);
        return $model;
    }

    public function actionSend_push()
    {
        $post = Yii::$app->request->post();
        $message = $post['message'];

        $users = AppUser::find()->where(['user_id' => $post['users']])->asArray()->all();
        $emails = ArrayHelper::getColumn($users, 'email');

        $response = Yii::$app->api->send_push_notification($message, $emails);


        return Yii::$app->api->_sendResponse(200, [$response], true);
    }

    public function actionMarket_reports()
    {
        $post = Yii::$app->request->post();
        $setting = $post['setting'];

        if (isset($post['users']))
            $users = AppUser::updateAll(['market_report_access_level' => $setting], ['user_id' => $post['users']]);


        return Yii::$app->api->_sendResponse(200);
    }
}
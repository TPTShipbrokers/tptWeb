<?php

namespace app\modules\api\controllers;

use app\models\AppUser;
use Yii;

class UserController extends DefaultController
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post', 'put'],

                    'team' => ['get'],

                ],
            ],
        ];
    }

    public function init()
    {
        $this->model = 'app\models\AppUser';
    }


    public function actionIndex($id = null)
    {
        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        $this->{$req['action']}($req['object']);
    }

    public function viewRecord()
    {
        $m = $this->model;

        if ($this->pkId == null) {
            if (!$this->user_id) {
                Yii::$app->api->_sendResponse(401, ["error" => "invalid_operation", "error_description" => ["User not authorized for this operation."]], false);
            } else {
                $this->pkId = $this->user_id;
            }

        }

        $record = $m::findOne($this->pkId);
        Yii::$app->utils->checkExistence($record);

        $record->viewRecord($this->user_id);
    }

    public function actionTeam()
    {
        $team = AppUser::format(AppUser::find()->where(['role' => AppUser::$roles['TEAM']])->all());
        Yii::$app->api->_sendResponse(200, $team, true);

    }

    public function actionChange_notification_settings()
    {

        $requestData = json_decode($this->requestData, true);

        $user = AppUser::findOne($this->user_id);
        Yii::$app->utils->checkExistence($user);

        $notificationSettings = $user->notificationSettings;
        $notificationSettings->attributes = $requestData;

        $res = $notificationSettings->trySave(true);

        if ($res['result'] != 'success') {
            return Yii::$app->api->_sendResponse(200, $res['data'], false);
        }

        return Yii::$app->api->_sendResponse(200);
    }


}

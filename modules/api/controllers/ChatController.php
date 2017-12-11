<?php

namespace app\modules\api\controllers;

use app\models\AppUser;
use app\models\Chat;
use Yii;
use yii\web\Controller;

/**
 * Class ChatController
 * @package app\modules\api\controllers
 */
class ChatController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'unread_messages' => ['get'],
                    'save_message' => ['post'],
                    'change_user_status' => ['post'],
                    'messages' => ['post'],
                    'check_statuses' => ['get'],
                    'mark_read' => ['post'],
                    'send_push_notification' => ['post'],

                ],
            ],
        ];
    }

    /**
     * @param null $params
     * @return mixed
     */
    public function actionUnread_messages($params = null)
    {

        return Yii::$app->api->_sendResponse(200, Chat::format(Chat::find()->where(['to_id' => $params, 'status' => 'unread'])->all(), ['from' => true]), true, false);
    }

    public function actionSave_message()
    {
        $request = file_get_contents('php://input');
        $json = json_decode($request);

        $model = new Chat;

        $model->from_id = $json->from_id;
        $model->to_id = $json->to_id;
        $model->message = $json->message;
        $model->status = $json->status;

        $to = AppUser::findOne($json->to_id);
        Yii::$app->utils->checkExistence($model);

        if ($json->status == 'read' && $to->role != 'client') {
            $model->status = 'unread';
        }

        if ($json->status == 'unread' && $to->role == 'client') {

            $from = AppUser::findOne($json->from_id);
            Yii::$app->utils->checkExistence($from);

            //$r = Yii::$app->api->send_push_notification('New message from ' . $from->first_name . ' ' . $from->last_name, [$to->email]);
            // die(var_dump($r));
        }

        if ($model->validate()) {
            $model->save();
            Yii::$app->api->_sendResponse(200, '', true);
        } else {
            Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => $model->getErrors()], false);
        }
    }

    public function actionChange_user_status()
    {
        $request = file_get_contents('php://input');
        $json = json_decode($request);


        $model = AppUser::findOne($json->user_id);

        if ($model) {
            $model->status = $json->status;
            $model->save();
            Yii::$app->api->_sendResponse(200, '', true);
        } else {
            Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => 'Unknown user'], false);
        }

    }

    public function actionCheck_statuses()
    {
        return Yii::$app->api->_sendResponse(200, AppUser::format(AppUser::find()->select('user_id, status')->all(), []), true, false);

    }

    public function actionMessages()
    {
        $post = Yii::$app->request->post();
        return Yii::$app->api->_sendResponse(200, Chat::format(Chat::find()->where(['to_id' => $post['to_id'], 'from_id' => $post['from_id']])->orWhere(['from_id' => $post['to_id'], 'to_id' => $post['from_id']])->orderby('date')->all(), ['to' => true, 'from' => true]), true);

    }

    public function actionMark_read()
    {
        $request = file_get_contents('php://input');

        $post = json_decode($request, true);

        if (empty($post)) {
            $post = Yii::$app->request->post();
        }

        if (!empty($post)) {
            $messages = Chat::find()->where(['status' => 'unread', 'from_id' => $post['from_id'], 'to_id' => $post['to_id']])->all();

            foreach ($messages as $message) {
                $message->status = 'read';
                $r = $message->trySave(true);
                if ($r['result'] != 'success') {
                    return Yii::$app->api->_sendResponse(200, $r['data'], false);
                }
            }

            return Yii::$app->api->_sendResponse(200);
        } else {
            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid data', 'error_description' => 'Request empty'], false);
        }

    }


}

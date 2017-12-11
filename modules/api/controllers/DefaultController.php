<?php

namespace app\modules\api\controllers;

use Yii;

class DefaultController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $user_id;
    public $access_token;
    public $requestData;
    public $model;
    public $pkId;

    public function beforeAction($action)
    {

        error_reporting(E_ALL ^ E_NOTICE);

        // Fetch request data before auhorization (php://input can be read just once)

        $json = file_get_contents('php://input');


        if (($action->id == 'profile_picture' && !Yii::$app->request->isGet)) {
            $json = Yii::$app->api->parseFormData($json);

        }


        $this->requestData = $json;

        $this->enableCsrfValidation = false;
        $request = \OAuth2\Request::createFromGlobals();

        $auth = Yii::$app->user->authenticate($request);

        $public = Yii::$app->api->checkPublicActions();

        // if its not public action and user is not passing authentication based on access token
        if (!$public && !$auth['result']) {

            Yii::$app->api->_sendResponse(401, $auth['response']->getParameters(), false);

            return false;
        } else {

            // For public actions user_id and access_token is set to null
            $this->user_id = $auth['user_id'] ? $auth['user_id'] : null;
            $this->access_token = $auth['access_token'] ? $auth['access_token'] : null;
        }


        return parent::beforeAction($action);

    }

    public function createRecord($record)
    {

        $newRecord = new $this->model;

        $newRecord->createRecord($record, $this->user_id);
    }

    public function viewRecord()
    {
        $m = $this->model;

        $record = $m::findOne($this->pkId);
        Yii::$app->utils->checkExistence($record);

        $record->viewRecord($this->user_id);
    }

    public function updateRecord($record)
    {
        $m = $this->model;
        $pk = (new $m)->tableSchema->primaryKey[0];
        $oldRecord = $m::findOne($record[$pk]);

        /* For user edit - user_id is optional; 
         * in case its not set - search is performed based on authentication data (user_id) 
         */

        if (!isset($record[pk]) && $pk == 'user_id') {
            $oldRecord = $m::findOne($this->user_id);
        }

        Yii::$app->utils->checkExistence($oldRecord);
        $oldRecord->updateRecord($record, $this->user_id);
    }

    public function deleteRecord($record)
    {
        $m = $this->model;
        $oldRecord = $m::findOne($record[$this->pk]);
        Yii::$app->utils->checkExistence($oldRecord);
        $oldRecord->deleteRecord($this->user_id);
    }

    public function actionSend_email()
    {
        $post = Yii::$app->request->post();
        if ($this->requestData) {
            $post = json_decode($this->requestData);


            $to = $post->email;
            $subject = $post->subject;

            // TODO
            $files = is_array($post->files) ? $post->files : json_decode($post->files);
//var_dump(json_encode($files) );die();         


            $message = Yii::$app->mailer->compose()
                ->setFrom('admin@tunept.com')
                ->setTo($post->email)
                ->setSubject($post->subject)
                ->setHtmlBody($post->body);

            // TODO
            foreach ($files as $file_obj) {
//          foreach($post->files as $file_obj){

                if (isset($file_obj->file) && $file_obj->file && file_exists($file_obj->file)) {
                    $message->attach($file_obj->file, ['fileName' => $file_obj->filename]);
                }

                if (isset($file_obj->file) && !file_exists($file_obj->file)) {
                    return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid data', 'error_description' => 'File does not exist.'], false);
                }

            }

            $message->send();


            Yii::$app->api->_sendResponse(200);
        }

    }

}

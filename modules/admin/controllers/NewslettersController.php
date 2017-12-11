<?php

namespace app\modules\admin\controllers;

use app\models\Newsletter;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;


class NewslettersController extends Controller
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

        $data = ['newsletters' => Newsletter::format(Newsletter::find()->all(), ['model']), 'model' => new Newsletter];

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }

    }

    public function actionView($id)
    {
        $model = Newsletter::findOne($id);
        Yii::$app->utils->checkExistence($model);
        return $this->redirect(Url::home(true) . $model->file);
        // return $this->render('view', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Newsletter;

        $post = Yii::$app->request->post();

        if (isset($post['Newsletter'])) {

            $model->attributes = $post['Newsletter'];

            $file = UploadedFile::getInstance($model, 'file');

            if ($file) {
                $file_id = uniqid();
                $model->file = 'uploads/documents/' . $file->baseName . $file_id . '.' . $file->extension;
                $file->saveAs('uploads/documents/' . $file->baseName . $file_id . '.' . $file->extension);
            }

            $res = $model->trySave(true);

            if ($res['result'] != 'success') {

                return Yii::$app->api->_sendResponse(200, $res['data'], false);

            } else {

                $query = new Query;

                $query->select(['User.email'])
                    ->from('User')
                    ->join('INNER JOIN', 'NotificationSettings',
                        'User.notification_settings_id =NotificationSettings.notification_settings_id')
                    ->where(['newsletters' => 1]);

                $command = $query->createCommand();
                $data = $command->queryAll();

                $emails = array_map(function ($e) {
                    return $e["email"];
                }, $data);

                // die(var_dump($emails));

                //Yii::$app->api->send_push_notification('New market report ' . $model->title . ' available.', $emails);

                return Yii::$app->api->_sendResponse(200);
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = Newsletter::findOne($id);
        $post = Yii::$app->request->post();
        Yii::$app->utils->checkExistence($model);

        if (isset($post['Newsletter'])) {

            $old_file = $model->file;

            $model->attributes = $post['Newsletter'];

            $file = UploadedFile::getInstance($model, 'file');


            if ($file) {
                $model->file = 'uploads/documents/' . $file->baseName . uniqid() . '.' . $file->extension;
                $file->saveAs('uploads/documents/' . $file->baseName . uniqid() . '.' . $file->extension);
            } else {
                $model->file = $old_file;
            }

            $model->trySave();
        }


    }

    public function actionDelete($id)
    {
        $post = Yii::$app->request->post();

        $model = Newsletter::findOne($id);
        Yii::$app->utils->checkExistence($model);

        if ($model->file && file_exists($model->file)) {
            unlink($model->file);
        }

        $model->tryDelete();
    }


}

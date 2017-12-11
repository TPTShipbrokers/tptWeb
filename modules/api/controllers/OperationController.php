<?php

namespace app\modules\api\controllers;

use Yii;

class OperationController extends DefaultController
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'ongoing' => ['get'],
                    'past' => ['get']

                ],
            ],
        ];
    }

    public function init()
    {
        $this->model = 'app\models\Operation';
    }


    public function actionIndex($id = null)
    {
        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        $this->{$req['action']}($req['object']);
    }

    public function actionOngoing()
    {
        return $this->operations(false);
    }

    public function operations($past = false)
    {
        $m = $this->model;

        if ($this->pkId == null) {
            if (!$this->user_id) {
                Yii::$app->api->_sendResponse(401, ["error" => "invalid_operation", "error_description" => ["User not authorized for this operation."]], false);
            }

        }

        $cond = $past ? 'end_time is not null' : ['end_time' => null];
        $records = $m::find()->where(['user_id' => $this->user_id])->andWhere($cond)->all();
        $data = $m::format($records, ['statuses' => true, 'invoice' => true, 'report' => true, 'api' => true]);

        return Yii::$app->api->_sendResponse(200, $data, true, $return);
    }

    public function actionPast()
    {
        return $this->operations(true);
    }

    public function viewRecord()
    {
        // die();
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


}

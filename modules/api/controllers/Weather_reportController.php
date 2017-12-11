<?php

namespace app\modules\api\controllers;

use app\models\Location;
use app\models\WeatherReport;
use Yii;

class Weather_reportController extends DefaultController
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],

                ],
            ],
        ];
    }

    public function init()
    {
        $this->model = 'app\models\WeatherReport';
    }


    public function actionIndex($id = null)
    {
        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        $this->{$req['action']}($req['object']);


    }


}

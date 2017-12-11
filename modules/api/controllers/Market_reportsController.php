<?php

namespace app\modules\api\controllers;

use app\models\AppUser;
use app\models\Location;
use app\models\Newsletter;
use app\models\WeatherReport;
use Yii;

class Market_reportsController extends DefaultController
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
        $this->model = 'app\models\Newsletter';
    }


    public function actionIndex($id = null)
    {
        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        $user = AppUser::findOne($this->user_id);


        if ($user->market_report_access_level == 0) {
            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => 'User don\'t have permission to access market reports.'], false);
        }

        if (!$id) {
            $this->allNewsletters();
        } else {
            $this->{$req['action']}($req['object']);
        }


    }

    public function allNewsletters()
    {
        //  $models = Newsletters::find()->orderby('date desc')->all();
        return Yii::$app->api->_sendResponse(200, Newsletter::format(Newsletter::find()->orderby('date desc')->all(), [], false), true, false);

    }


}

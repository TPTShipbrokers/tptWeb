<?php

namespace app\modules\api\controllers;

use app\models\AppUser;
use app\models\Chartering;
use app\models\CharteringClient;
use app\models\CharteringCompany;
use Yii;

class CharteringController extends DefaultController
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
        $this->model = 'app\models\Chartering';
    }

    public function actionIndex($id = null)
    {

        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        if (!$id) {
            $this->allChartering();
        } else {
            $this->{$req['action']}($req['object']);
        }


    }

    public function allChartering()
    {
        $user = AppUser::findOne($this->user_id);
        $records = Chartering::find()
            ->where('state <> \'completed\'')
            ->andWhere(' exists (
                        select * 
                        from CharteringClient  
                        where CharteringClient.Chartering_id = Chartering.chartering_id and CharteringClient.client_id=:client_id and CharteringClient.status in (\'active\', \'read\')
                        ) 
                        or exists(
                            select *
                            from CharteringCompany
                            where CharteringCompany.chartering_id=Chartering.chartering_id and CharteringCompany.company_id=:company_id

                            )',
                [':client_id' => $this->user_id, ':company_id' => $user->company_id])
            ->all();
        return Yii::$app->api->_sendResponse(200, Chartering::format($records, ['vessel' => true, 'status' => true, 'charter_party_date' => true, 'invoices' => true, 'broker' => true]), true, false);

    }

    public function viewRecord($user_id = null, $return = false)
    {

        $chartering = Chartering::findOne($this->pkId);

        Yii::$app->utils->checkExistence($chartering);
        $user = AppUser::findOne($this->user_id);
        $charteringClient = CharteringClient::find()->where(['client_id' => $this->user_id, 'chartering_id' => $this->pkId])->select('client_id')->asArray()->all();

        $user_ids = array_map(function ($el) {
            return $el["client_id"];
        }, $charteringClient);

        $charteringCompanies = CharteringCompany::find()->where(['chartering_id' => $this->pkId])->select('company_id')->asArray()->all();
        $company_ids = array_map(function ($el) {
            return $el["company_id"];
        }, $charteringCompanies);

        if (!in_array($this->user_id, $user_ids) && !in_array($user->company_id, $company_ids)) {
            return Yii::$app->api->_sendResponse(401, ['error' => 'Unauthorized', 'error_description' => 'User not authorized for this operation.'], false);
        }

        return Yii::$app->api->_sendResponse(200, Chartering::format($chartering, [
            'statuses' => true,
            'status' => true,
            'charter_party' => true,
            'invoices' => true,
            'claims' => ['claim_documentations' => true],
            'broker' => true,
            'ship_documentations' => true,
            'invoice_documentations' => true
        ], true), true, $return);
    }

    public function actionPost()
    {
        $user = AppUser::findOne($this->user_id);
        $records = Chartering::find()
            ->joinWith('charteringClients')
            ->where(['state' => 'completed'])
            ->andWhere(' exists (
                        select * 
                        from CharteringClient  
                        where CharteringClient.Chartering_id = Chartering.chartering_id and CharteringClient.client_id=:client_id and CharteringClient.status in (\'active\', \'read\')
                        ) 
                        or exists(
                            select *
                            from CharteringCompany
                            where CharteringCompany.chartering_id=Chartering.chartering_id and CharteringCompany.company_id=:company_id

                            )',
                [':client_id' => $this->user_id, ':company_id' => $user->company_id])
            ->all();

        return Yii::$app->api->_sendResponse(200, Chartering::format($records, ['vessel' => true, 'status' => true, 'charter_party_date' => true, 'invoices' => true, 'broker' => true]), true, false);

    }

}
    
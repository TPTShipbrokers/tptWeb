<?php

namespace app\modules\api\controllers;

use app\models\CharterParty;
use Yii;

/**
 * Class Charter_partyController
 * @package app\modules\api\controllers
 */
class Charter_partyController extends DefaultController
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
                    'index' => ['get'],

                ],
            ],
        ];
    }

    public function init()
    {
        $this->model = 'app\models\CharterParty';
    }

    /**
     * @param $id
     */
    public function actionIndex($id)
    {
        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        $this->{$req['action']}($req['object']);
    }

    /**
     * @param null $user_id
     * @param bool $return
     * @return mixed
     */
    public function viewRecord($user_id = null, $return = false)
    {

        return Yii::$app->api->_sendResponse(200, CharterParty::format(CharterParty::findOne($this->pkId), [], false), true, $return);
    }
}

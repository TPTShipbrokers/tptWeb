<?php

namespace app\modules\api\controllers;

use app\modules\api\components\OAuth2Server;
use app\modules\api\components\OAuth2StoragePDO;
use OAuth2\Request;
use Yii;
use yii\web\Controller;

/**
 * Class Oauth2Controller
 * @package app\modules\api\controllers
 */
class Oauth2Controller extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @var OAuth2Server
     */
    protected $_server;

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        error_reporting(E_ALL ^ E_NOTICE);

        if (!parent::beforeAction($action)) {
            return false;
        }

        $db = Yii::$app->db;

        $storage = new OAuth2StoragePDO([
            'dsn' => $db->dsn,
            'username' => $db->username,
            'password' => $db->password
        ],
            ['user_table' => 'User']
        );
        $server = new OAuth2Server($storage, [
            'enforce_state' => false,
            'access_lifetime' => 3600 * 24,
            'refresh_token_lifetime' => 2419200
        ]);

        $this->_server = $server;
        return true;
    }

    /**
     * @return mixed
     */
    public function actionToken()
    {
        $oauthRequest = Request::createFromGlobals();
        $request = $oauthRequest->request;

        $username = $request["username"];
        $password = $request["password"];
        $user = Yii::$app->user->checkExistence($username, $password);
        //    die(var_dump($user));
        $oauthRequest->request = $request;

        $this->_server->handleTokenRequest($oauthRequest)->send();
        exit();
    }


}

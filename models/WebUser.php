<?php
namespace app\models;

use app\modules\api\components\OAuth2Server;
use app\modules\api\components\OAuth2StoragePDO;
use Yii;

/**
 * Class WebUser
 * @package app\models
 */
class WebUser extends \yii\web\User
{
    /**
     * @var OAuth2Server
     */
    protected $_server;

    /**
     * @return bool
     */
    public function init()
    {
        parent::init();

        $db = Yii::$app->db;

        $storage = new OAuth2StoragePDO(['dsn' => $db->dsn, 'username' => $db->username, 'password' => $db->password]);
        $server = new OAuth2Server($storage, ['enforce_state' => false, 'access_lifetime' => 3600 * 24, 'refresh_token_lifetime' => 2419200]);

        $this->_server = $server;
        return true;
    }

    /**
     * @param $request
     * @param bool $is_request
     * @return array|bool
     */
    public function authenticate($request, $is_request = true)
    {

        if (!$is_request) {
            // $request - token
            $users = Yii::$app->db->createCommand('SELECT * FROM oauth_access_tokens WHERE access_token=:request AND expires > NOW()')
                ->bindParam(':request', $request)
                ->queryAll();

            if (!empty($users)) {
                return $users[0]["user_id"];
            } else {
                return false;
            }

        }

        $authenticated = $this->_server->verifyResourceRequest($request);
        $accessTokenData = $this->_server->getAccessTokenData($request);

        if (!$authenticated) {
            $result = ['result' => false, 'response' => $this->_server->getResponse()];
            return $result;
        } else {

            $result = ['result' => true, 'user_id' => $accessTokenData['user_id'], 'access_token' => $accessTokenData['access_token']];
            return $result;
        }
    }

    public function checkExistence($username, $password = null)
    {
        $pass = $password != null ? sha1($password) : $password;

        return AppUser::find()->where(['email' => $username, 'password' => $pass])->one();
    }

    /**
     * @param string $name
     * @return mixed|void
     */
    public function __get($name)
    {
        /* if ($this->hasState('__userInfo')) {
             $user=$this->getState('__userInfo',array());
             if (isset($user[$name])) {
                 return $user[$name];
             }
         }

         return parent::__get($name);*/
    }


    /**
     * Required to checkAccess function
     * Yii::app()->user->checkAccess('operation')
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }
}


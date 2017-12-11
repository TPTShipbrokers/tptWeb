<?php

namespace app\models;

class User extends \yii\web\User implements \yii\web\IdentityInterface
{

    public static $users;
    public $user_id;
    public $first_name;
    public $last_name;
    public $email;
    public $email2;
    public $password;
    public $role;
    public $position;
    public $phone;
    public $phone2;
    public $profile_picture;
    public $operations;
    public $notification_settings_id;
    public $company_id;
    public $market_report_access_level;
    public $authKey;
    public $auth_key;
    public $accessToken;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return new static(AppUser::findOne(['user_id' => $id]));
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                // return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param $email
     * @return null|static
     * @internal param string $username
     */
    public static function findByUsername($email)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['email'], $email) === 0 /*&& $user['role'] === AppUser::$roles['ADMIN']*/) {
                return new static($user);
            }
        }

        return null;
    }

    public function init()
    {
        self::$users = AppUser::find()->asArray()->all();
    }

    public function authenticate()
    {

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @inheritdoc
     */
    public function setAuthKey($authKey)
    {
        return $this->authKey = $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }
}

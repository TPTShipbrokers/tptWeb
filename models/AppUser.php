<?php

namespace app\models;

use Yii;
use yii\helpers\Url as Url;

/**
 * This is the model class for table "User".
 *
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $position
 * @property string $phone
 * @property string $phone2
 * @property string $profile_picture
 * @property string $notification_settings_id
 * @property string $market_report_access_level
 *
 * @property Operation[] $operations
 * @property NotificationSettings $notificationSettings
 * @property Company $company
 */
class AppUser extends DefaultModel
{
    public static $roles = ['ADMIN' => 'admin', 'CLIENT' => 'client', 'TEAM' => 'team'];
    public static $pk_field = 'user_id';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/user/', true);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'role'], 'required'],
            [['role', 'position'], 'string'],
            [['notification_settings_id', 'company_id', 'market_report_access_level'], 'integer'],
            [['email'], 'unique'],
            [['notification_settings_id'], 'unique'],
            [['first_name', 'last_name', 'email', 'email2', 'password', 'phone', 'phone2'], 'string', 'max' => 255],
            [['profile_picture'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->profile_picture->saveAs('uploads/images/' . $this->profile_picture->baseName . '.' . $this->profile_picture->extension);
            $this->profile_picture = 'uploads/images/' . $this->profile_picture->baseName . '.' . $this->profile_picture->extension;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'email2' => 'Email 2',
            'password' => 'Password',
            'role' => 'Role',
            'position' => 'Position',
            'phone' => 'Phone',
            'phone2' => 'Phone 2',
            'profile_picture' => 'Profile Picture',
            'company_id' => 'Company ID',
            'market_report_access_level' => 'Market Reports Access Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartering($past = false)
    {
        return Chartering::find()->where(($past ? '' : 'not ') . ' exists(select * from CharteringStatuses join Status on Status.status_id=CharteringStatuses.status_id where final=1 and chartering_id=Chartering.chartering_id)')->andWhere('exists (select * from CharteringClient where client_id=:client_id and chartering_id=Chartering.chartering_id)', [':client_id' => $this->user_id]);
    }

    public function getNotificationSettings()
    {
        return $this->hasOne(NotificationSettings::className(), ['notification_settings_id' => 'notification_settings_id']);
    }


    public function viewRecord($user_id = null, $return = false)
    {

        $data = self::format($this, ['notification_settings' => true]);

        return Yii::$app->api->_sendResponse(200, $data, true, $return);

    }

    public static function format($users, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($users)) {
            foreach ($users as $user) {
                $result[] = self::format($user, $includes, true);
            }

            return $result;

        } else {

            $res = self::formatData($users, self::className(), false, true);
            if (isset($includes['notification_settings']) && $includes['notification_settings'] == true) {
                $res['notification_settings'] = NotificationSettings::format($users->notificationSettings, [], false);
            }

            if (isset($includes['full_name']) && $includes['full_name'] == true) {
                $res['full_name'] = $users->first_name . ' ' . $users->last_name;
            }

            unset($res['password']);


            return $res;
        }
    }

    public function updateRecord($record, $user_id = null, $return = false)
    {

        if ($user_id) {
            $this->validateAuth($user_id);
        }

        if (isset($record["user_id"]) && $record["user_id"] != null) {
            $this->validateAuth($record['user_id']);
        }

        //  $this->attributes = $record;

        if (isset($record['email'])) {
            $this->email = $record['email'];
        }

        if (isset($record['status']) && in_array($record['status'], AppUser::$statuses)) {
            $this->status = $record['status'];
        } else if (isset($record['status'])) {
            Yii::$app->api->_sendResponse(200, ["error" => "invalid_operation", "error_description" => ["User data malformed! Incorrect status: " . $record['status'] . "."]], false);
        }

        if (isset($record['password'])) {
            $this->password = sha1($record['password']);
        }

        $result = $this->trySave($return);

        if ($result["result"] != "success") {


            if ($return) {
                return Yii::$app->api->_sendResponse(200, '', true, $return);
            } else {

                Yii::$app->api->_sendResponse(200, $result["data"], false, $return);
            }
        }


    }


}

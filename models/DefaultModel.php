<?php

namespace app\models;

use Yii;
use yii\helpers\Url as Url;

/**
 * This is the parent model class all api models
 */
class DefaultModel extends \yii\db\ActiveRecord
{
    public static $defaultResponseParams = [
        "parameters" => [
            'result' => '<b>success</b>,<b>error</b>',
            'status' => 'Request Status Code',
            'message' => 'Request Status Description',
            'data' => [
                '<span class="label label-success">String</span>' => 'Server proccessing results (optional)'
            ]
        ]
    ];

    public static function info()
    {
        $m = self::className();
        return [
            'primary_key' => (new $m)->tableSchema->primaryKey[0],
            'model' => $m,
        ];
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/', true);
    }

    public static function route($params, $api = false)
    {

        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;

        if ($api) {
            return Url::toRoute('/api/' . $action . '/' . $params, true);
        }

        return Url::toRoute($controller . '/' . $action . '/' . $params, true);
    }

    public static function getApiEndpoint($model, $id)
    {
        return $model::rootUrl() . "/" . $id;
    }

    public static function getUserRole($user_id)
    {
        return AppUser::findOne($user_id)->role;
    }

    public static function format($records, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($records)) {
            foreach ($records as $record) {
                $result[] = self::format($record, $includes, $api_endpoint);
            }

            return $result;

        } else {

            $res = self::formatData($records, self::className(), false, $api_endpoint);

            $info = $records::info();


            if (isset($includes['update_url']) && $includes['update_url'] == true) {
                $res['update_url'] = Url::toRoute($info['controller_id'] . '/update/' . $records->{$info['primary_key']});
            }

            if (isset($includes['delete_url']) && $includes['delete_url'] == true) {
                $res['delete_url'] = Url::toRoute($info['controller_id'] . '/delete/' . $records->{$info['primary_key']});
            }

            return $res;
        }
    }

    public static function formatData($data, $model, $arr = false, $api_endpoint = true)
    {

        // if data is array of entities - process those one by one
        if (is_array($data)) {

            $result = [];
            foreach ($data as $resource) {
                $result[] = self::formatData($resource, $model, false, $api_endpoint);
            }
            return $result;
        } else {

            $res = $data->attributes;

            // else - return data(entity) + api_endpoint
            $pk = (new $model)->tableSchema->primaryKey[0];
            if ($api_endpoint) {
                $res["api_endpoint"] = $model::rootUrl() . "/" . $res[$pk];
            }

            $data = $res;

        }

        return $data;
    }

    public function viewRecord($user_id = null, $return = false)
    {
        if ($user_id != null) {
            $this->validateAuth($user_id);
        }
        return Yii::$app->api->_sendResponse(200, [(array)$this->attributes], true, $return);
    }

    public function validateAuth($user_id = null)
    {


        if ($user_id != null && $user_id != $this->user_id) {
            Yii::$app->api->_sendResponse(401, ["error" => "invalid_operation", "error_description" => ["User not authorized for this operation."]], false);
        }
    }

    public function createRecord($record, $user_id = null, $return = false)
    {

        if ($user_id != null && in_array('user_id', array_keys($this->attributes))) {
            $this->user_id = $user_id;
        }

        $this->attributes = $record;

        $result = $this->trySave($return);

        if ($result["result"] != "success") {


            if ($return) {
                return $result;
            } else {

                Yii::$app->api->_sendResponse(200, $result["data"], false, $return);
            }
        }

    }

    public function trySave($return = false)
    {
        if ($this->save()) {
            return Yii::$app->api->_sendResponse(200, '', true, $return);

        } else {

            return Yii::$app->api->_sendResponse(200, ["error" => "Invalid Data.", "error_description" => Yii::$app->api->processErrors($this->getErrors())], false, $return);
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

        $this->attributes = $record;

        $result = $this->trySave($return);

        if ($result["result"] != "success") {


            if ($return) {
                return $result;
            } else {

                Yii::$app->api->_sendResponse(200, $result["data"], false, $return);
            }
        }

    }

    public function deleteRecord($user_id = null, $return = false)
    {

        $this->validateAuth($user_id);

        if ($this->delete()) {
            return Yii::$app->api->_sendResponse(200, '', true, $return);
        } else {
            return Yii::$app->api->_sendResponse(200, ["error" => "Server processing error.", "error_description" => Yii::$app->api->processErrors($this->getErrors())], false, $return);
        }


    }

    public function trySaveGeneral($transaction = null)
    {

        $res = $this->trySave(true);

        if ($res['result'] != 'success') {
            if ($transaction)
                $transaction->rollBack();
            return Yii::$app->api->_sendResponse(200, $res['data'], false);
        }
    }

    public function tryDeleteGeneral($transaction = null)
    {

        $res = $this->tryDelete(true);

        if ($res['result'] != 'success') {
            if ($transaction)
                $transaction->rollBack();
            return Yii::$app->api->_sendResponse(200, $res['data'], false);
        }
    }

    public function tryDelete($return = false)
    {
        if ($this->delete()) {
            return Yii::$app->api->_sendResponse(200, '', true, $return);
        } else {
            return Yii::$app->api->_sendResponse(200, ["error" => "Invalid Data.", "error_description" => Yii::$app->api->processErrors($this->getErrors())], false, $return);
        }
    }


}

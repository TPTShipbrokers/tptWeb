<?php

namespace app\modules\admin\controllers;

use app\models\Invoice;
use app\models\Location;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;


class InvoiceController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'column2';

    public function beforeAction($action)
    {
        if (\Yii::$app->getModule('admin')->user->isGuest) {
            $this->redirect(Url::toRoute('login/'));
        }

        if (!parent::beforeAction($action)) return false;

        return true;
    }

    public function actionIndex()
    {

        $data = ['invoices' => Invoice::format(Location::find()->all())];

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }

    }


    public function actionCreate()
    {
        $model = new Location;

        $post = Yii::$app->request->post();

        if (isset($post['Location'])) {


            $model->attributes = $post['Location'];


            if ($model->validate()) {

                $model->save();


                Yii::$app->api->_sendResponse(200);

            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }

        }
    }

    public function actionUpdate($id)
    {
        $model = Location::findOne($id);
        $post = Yii::$app->request->post();

        if (isset($post['Location'])) {

            if ($model != null) {

                $model->attributes = $post['Location'];


                if ($model->validate()) {

                    $model->save();

                    Yii::$app->api->_sendResponse(200);

                } else {
                    Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => array_values($model->getErrors())], false);
                }


            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Location with supplied id does not exist.'], false);

            }

        }

    }

    public function actionDelete()
    {
        $post = Yii::$app->request->post();

        $model = Location::findOne($post['location_id']);

        if ($model != null) {

            $operation_ongoing = $model->getOperations()->where(['location_id' => $model->location_id, 'end_time' => null])->all();

            if ($operation_ongoing) {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => 'You can not delete location that\'s been set as a location for some ongoing operation.'], false);
            }

            $operation_past = $model->getOperations()->where(['location_id' => $model->location_id])->andWhere('end_time is not null')->all();


            if ($operation_past) {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => 'You can not delete location that\'s been set as a location for some operation. You have to delete operation first.'], false);
            }

            if ($model->delete()) {
                Yii::$app->api->_sendResponse(200);
            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }


        } else {

            Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Location with supplied id does not exist.'], false);

        }
    }


}

<?php

namespace app\modules\admin\controllers;

use app\models\Ship;
use app\models\Status;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;


class StatusesController extends Controller
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

        $data = [
            'rows' => Status::format(Status::find()->all(), ['update_url' => true, 'delete_url' => true], false),
            'attributes' => ['Description' => 'description'],
            'info' => Status::info(),
            'title' => 'Statuses',
            'edit_field' => 'description'
        ];

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }

    }


    public function actionCreate()
    {
        $model = new Status;

        $post = Yii::$app->request->post();

        if (isset($post['Status'])) {

            $model->attributes = $post['Status'];
            $model->trySave();

        }
    }

    public function actionUpdate($id)
    {
        $model = Status::findOne($id);
        $post = Yii::$app->request->post();

        if (isset($post['Status'])) {

            if ($model != null) {

                $model->attributes = $post['Status'];
                $model->trySave();
            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Status with supplied id does not exist.'], false);

            }

        }

    }

    public function actionDelete($id)
    {

        $post = Yii::$app->request->post();
        $model = Status::findOne($id);

        if ($model != null) {

            $chartering_statuses = $model->getCharteringStatuses()->all();

            if (!empty($chartering_statuses)) {
                $op_link = '';

                foreach ($chartering_statuses as $chartering_status) {
                    $chartering = $chartering_status->chartering;
                    $op_link .= '<span class="label label-danger label-sm"><a href="' . Url::toRoute('chartering/view/' . ($chartering->chartering_id)) . '" target="_blank">' . $chartering->vessel_name . '</a></span><br>';

                }
                return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => 'You can not delete status because it is set as status for some chartering. Chartering:<br> ' . $op_link], false);
            }


            $model->tryDelete();


        } else {

            Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Status with supplied id does not exist.'], false);

        }
    }


}

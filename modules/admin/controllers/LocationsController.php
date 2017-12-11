<?php

namespace app\modules\admin\controllers;

use app\models\Location;
use app\models\WeatherReport;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;


class LocationsController extends Controller
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

        $data = ['locations' => Location::format(Location::find()->all(), ['weather_reports' => true])];

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

    /*  public function actionAdd_weather_report($id){

        $model = Location::findOne($id);
        Yii::$app->utils->checkExistence($model);
        if(isset($post['Location']['report'])){

            $report = $post['Location']['report'];

            $rows = split("\n", $report);
            foreach($rows as $row){

              $line = ereg_replace( "\s|\n|\r",'', $row);
              $items = preg_match("/^(\d\d?\/\d\d?)\s+((\d\d?)(am|pm))\s+((\d+)\s*?-\s*?(\d+))\s+(([SEWN]+)\s*?(\d+))\s+(\d+\.\d+)\s+(\d+\.\d+)\s+((\d+)\s*?-\s*?(\d+))\s+(([SEWN]+)\s*?(\d+))/", $line, $matches);

              if(!empty($matches)){
                $report = new WeatherReport;
                $date = explode('/', $matches[1]);
                if($matches[4] == 'pm'){
                  $matches[3] = intval($matches[3]) + 12;
                }

                $report->datetime = date('Y-m-d H:i:s', mktime($matches[3], 0, 0, $date[0], $date[1], date("Y")));
                $report->surf_min = $matches[6];
                $report->surf_max = $matches[7];
                $report->surf_dir = $matches[9];
                $report->surf_deg = $matches[10];
                $report->seas = $matches[11];
                $report->period = $matches[12];
                $report->wind_min = $matches[14];
                $report->wind_max = $matches[15];
                $report->wind_dir = $matches[17];
                $report->wind_deg = $matches[18];
                $report->location_id = $id;

                if($report->validate()){
                  $report->save();
                } else {
                  return Yii::$app->api->_sendResponse(200, ['error'=>'Invalid Data', 'error_description' =>array_values($report->getErrors())], false);
                }
              }


            }

             $query = new Query;

            $query  ->select([
                'User.email'
                ]

                )
            ->from('User')
            ->join('INNER JOIN', 'NotificationSettings',
                        'User.notification_settings_id =NotificationSettings.notification_settings_id')
            ->where(['weather_reports' => 1]);



            $command = $query->createCommand();
            $data = $command->queryAll();

            die(var_dump($data));

              return Yii::$app->api->_sendResponse(200);


            } else if($post['WeatherReport']){

              if(isset($post['WeatherReport']['weather_report_id']) && $post['WeatherReport']['weather_report_id']){
                $report = WeatherReport::findOne($post['WeatherReport']['weather_report_id']);
              } else {
                $report = new WeatherReport;
              }

              $report->attributes = $post['WeatherReport'];
              $report->location_id = $id;


              $r = $report->trySave();

              if($r['result'] != 'success')
              {
                return Yii::$app->api->_sendResponse(200, $r['data'], false);
              } else {
                  $query = new Query;

                  $query  ->select([
                      'User.email'
                      ]

                      )
                  ->from('User')
                  ->join('INNER JOIN', 'NotificationSettings',
                              'User.notification_settings_id =NotificationSettings.notification_settings_id')
                  ->where(['weather_reports' => 1]);



                  $command = $query->createCommand();
                  $data = $command->queryAll();

                  die(var_dump($data));
              }


          }
      }*/

    public function actionUpdate($id)
    {
        $model = Location::findOne($id);
        Yii::$app->utils->checkExistence($model);

        $post = Yii::$app->request->post();

        if (isset($post['Location'])) {

            if (isset($post['Location']['report'])) {
                //     die('here');
                $report = $post['Location']['report'];
                // $newList = ereg_replace( "\n",'|', $report);
                $rows = split("\n", $report);
                foreach ($rows as $row) {
                    $line = ereg_replace("\s|\n|\r", '', $row);
                    $items = preg_match("/^(\d\d?\/\d\d?)\s+((\d\d?)(am|pm))\s+((\d+)\s*?-\s*?(\d+))\s+(([SEWN]+)\s*?(\d+))\s+(\d+\.\d+)\s+(\d+\.\d+)\s+((\d+)\s*?-\s*?(\d+))\s+(([SEWN]+)\s*?(\d+))/", $line, $matches);
                    //var_dump($matches);
                    if (!empty($matches)) {
                        $report = new WeatherReport;
                        $date = explode('/', $matches[1]);
                        if ($matches[4] == 'pm') {
                            $matches[3] = intval($matches[3]) + 12;
                        }

                        $report->datetime = date('Y-m-d H:i:s', mktime($matches[3], 0, 0, $date[0], $date[1], date("Y")));
                        $report->surf_min = $matches[6];
                        $report->surf_max = $matches[7];
                        $report->surf_dir = $matches[9];
                        $report->surf_deg = $matches[10];
                        $report->seas = $matches[11];
                        $report->period = $matches[12];
                        $report->wind_min = $matches[14];
                        $report->wind_max = $matches[15];
                        $report->wind_dir = $matches[17];
                        $report->wind_deg = $matches[18];
                        $report->location_id = $id;

                        if ($report->validate()) {
                            $report->save();
                        } else {
                            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => array_values($report->getErrors())], false);
                        }
                    }


                }

                $query = new Query;

                $query->select([
                        'User.email'
                    ]

                )
                    ->from('User')
                    ->join('INNER JOIN', 'NotificationSettings',
                        'User.notification_settings_id =NotificationSettings.notification_settings_id')
                    ->join('INNER JOIN', 'Operation',
                        'Operation.user_id = User.user_id')
                    ->where(['weather_reports' => 1])
                    ->andWhere(['Operation.location_id' => $id]);


                $command = $query->createCommand();
                $data = $command->queryAll();

                //die(var_dump());

                $emails = array_map(function ($e) {
                    return $e["email"];
                }, $data);

                //Yii::$app->api->send_push_notification('New weather report for location ' . $model->title . ' available.', $emails);

                return Yii::$app->api->_sendResponse(200);


            } else {
                $model->attributes = $post['Location'];
            }

            if ($model->validate()) {

                $model->save();

                return Yii::$app->api->_sendResponse(200);

            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => array_values($model->getErrors())], false);
            }


        } else if ($post['WeatherReport']) {

            if (isset($post['WeatherReport']['weather_report_id']) && $post['WeatherReport']['weather_report_id']) {
                $report = WeatherReport::findOne($post['WeatherReport']['weather_report_id']);
            } else {
                $report = new WeatherReport;
            }

            $report->attributes = $post['WeatherReport'];
            $report->location_id = $id;


            $r = $report->trySave();

            if ($r['result'] != 'success') {
                return Yii::$app->api->_sendResponse(200, $r['data'], false);
            } else {
                $query = new Query;

                $query->select([
                        'User.email'
                    ]

                )
                    ->from('User')
                    ->join('INNER JOIN', 'NotificationSettings',
                        'User.notification_settings_id =NotificationSettings.notification_settings_id')
                    ->where(['weather_reports' => 1]);


                $command = $query->createCommand();
                $data = $command->queryAll();

                die(var_dump($data));
            }


        }

    }

    public function actionUpdate_weather_report($id = null)
    {
        $post = Yii::$app->request->post();

        if (!empty($post)) {
            $action = $post['action'];

            if ($action == 'delete') {
                $id = $post['weather_report_id'];

                $weather_report = WeatherReport::findOne($id);

                if ($weather_report && $weather_report->delete()) {
                    Yii::$app->api->_sendResponse(200);
                }


            }

            if ($action == 'comment') {
                $id = $post['weather_report_id'];

                $weather_report = WeatherReport::findOne($id);

                Yii::$app->utils->checkExistence($weather_report);

                $weather_report->comment = $post['WeatherReport']['comment'];

                $weather_report->trySave();


            }

            if ($action == 'update') {
                $id = $post['weather_report_id'];

                $weather_report = WeatherReport::findOne($id);

                if ($weather_report && $weather_report->delete()) {
                    Yii::$app->api->_sendResponse(200);
                }


            }
        } else {
            return $this->renderPartial('weather_report_form', ['model' => WeatherReport::findOne($id)]);
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

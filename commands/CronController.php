<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

use app\models\AppUser;
use app\models\Chartering;
use app\models\CronJobs;
use Yii;
use yii\console\Controller;

class CronController extends Controller
{


    public function actionIndex($id)
    {
        $rows = AppUser::find()
            ->joinWith('notificationSettings')
            ->where(['NotificationSettings.subs_due' => 1])
            ->andWhere('User.user_id in (select client_id from CharteringClient where chartering_id=:chartering_id) or User.company_id in (select company_id from CharteringCompany where chartering_id=:chartering_id)', [':chartering_id' => $id])
            ->select('user_id, email, User.notification_settings_id')
            ->asArray()
            ->all();

        $emails = array_map(function ($e) {
            return $e["email"];
        }, $rows);

        $model = Chartering::findOne($id);

        //var_dump($emails);

        //Yii::$app->api->send_push_notification('Subs due for chartering ' . $model->vessel_name, $emails);

    }

    public function actionSubs($id)
    {
        $rows = AppUser::find()
            ->joinWith('notificationSettings')
            ->where(['NotificationSettings.subs_due' => 1])
            ->andWhere('User.user_id in (select client_id from CharteringClient where chartering_id=:chartering_id) or User.company_id in (select company_id from CharteringCompany where chartering_id=:chartering_id)', [':chartering_id' => $id])
            ->select('user_id, email, User.notification_settings_id')
            ->asArray()
            ->all();

        $emails = array_map(function ($e) {
            return $e["email"];
        }, $rows);

        $model = Chartering::findOne($id);

        $command = "cron/subs " . $id;

        //Yii::$app->api->send_push_notification('Subs due for chartering ' . $model->vessel_name, $emails);

        $cron = new CronJobs;
        $cron->succeeded = 1;
        $cron->action = 'cron job executed';
        $cron->parameters = $command;
        $cron->chartering_id = $id;
        $cron->datetime = $model->subs_due;
        $cron->chartering_id = $id;
        $cron->users = json_encode($emails);

        $cron->trySaveGeneral();

        Yii::$app->utils->deleteCron($model->subs_due, $command, $model->chartering_id);


    }

    public function execute($params, $job)
    {


        return $req;
    }


}


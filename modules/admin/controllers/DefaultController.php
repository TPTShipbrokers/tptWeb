<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use app\models\Chartering;
use app\models\Company;
use app\models\LoginForm;
use app\models\Newsletter;
use app\models\OauthAccessTokens;
use app\models\Status;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package app\modules\admin\controllers
 */
class DefaultController extends Controller
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
                    'login' => ['get', 'post'],
                    'dashboard' => ['get'],
                    'reset_password_request' => ['post'],
                    'reset_password' => ['get', 'post'],
                    'password_reset' => ['get'],
                ]
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionDashboard()
    {
        return $this->actionIndex();
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'column2';

        $data = [
            'Users' => AppUser::find()->count(),
            'Chartering' => Chartering::find()->count(),
            'WAF Positions' => \app\models\WafPosition::find()->count(),
            'UKC Positions' => \app\models\AraPosition::find()->count(),
            'Statuses' => Status::find()->count(),
            'Companies' => Company::find()->count(),
            'Market Reports' => Newsletter::find()->count(),
        ];

        if (!Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {

            $this->redirect(Url::toRoute('login'));
        }

    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {

        $this->layout = 'login';

        if (!Yii::$app->getModule('admin')->user->isGuest) {
            return $this->redirect(Url::toRoute('dashboard'));

        }

        $model = new LoginForm();
        $post = Yii::$app->request->post();

        if (!empty($post)) {
            if ($model->load($post) && $model->login(true)) {

                $this->redirect(Url::toRoute('dashboard'));

            } else {

                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }


    }

    /**
     * @return string
     */
    public function actionReset_password_request()
    {

        $this->layout = 'login';

        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $email = $post['email'];

            $user = AppUser::find()->where(['email' => $email])->one();


            if ($user == null) {
                // render notification page
                $link = '<a href="' . Url::toRoute('password_reset') . '" class="" >reset password page </a>';
                return $this->render('notification', ['type' => 'danger', 'message' => 'User with specified email does not exist. Please visit ' . $link . ' to request password reset again.']);

            } else {

                $time = time();
                $old_pass = $user->password;
                $hash = sha1($time . '-' . $old_pass);

                $token = new OauthAccessTokens;
                $token->user_id = $user->user_id;
                $token->client_id = 'mobileapp';
                $token->expires = date('Y-m-d H:i:s', time() + 600);
                $token->access_token = $hash;

                $token->save();

                $url = Url::toRoute('reset_password/' . $hash . '/' . $user->user_id, true);
                $user = AppUser::findOne($user->user_id);
                $name = $user->first_name . ' ' . $user->last_name;
                Yii::$app->mailer->compose('reset-password-email-view', ["url" => $url])
                    ->setFrom('TPT Mobile Application Registration <admin@tunept.com>')
                    ->setTo($email)
                    ->setSubject("Reset your password")
                    ->send();

                return $this->render('notification', ['type' => 'success', 'message' => 'Instructions to reset your password have been emailed to ' . $email . '. Please check your email for the next steps.']);
            }


        }
    }

    /**
     * @param $hash
     * @param $user_id
     * @return string
     */
    public function actionReset_password($hash, $user_id)
    {
        $this->layout = 'login';
        $token = OauthAccessTokens::find()->where(['user_id' => $user_id])->andWhere(['access_token' => $hash])->one();

        if (strtotime($token->expires) - time() < 0) {
            // istekao token - stranica za notif, gresku
            $link = '<a href="' . Url::toRoute('password_password') . '" class="" >reset password page </a>';
            return $this->render('notification', ['type' => 'error', 'message' => 'Reset password token expired. Please visit ' . $link . ' to request password reset again.']);
        } else {
            $user = AppUser::findOne($user_id);
            $original_time = strtotime($token->expires) - 600;
            $h = sha1($original_time . '-' . $user->password);

            if ($h != $hash) {
                // greska - ne poklapaju se hesevi
                $link = '<a href="' . Url::toRoute('password_reset') . '" class="" >reset password page </a>';
                return $this->render('notification', ['type' => 'error', 'message' => 'An error occured. Please visit ' . $link . ' to request password reset again.']);
            }

            $post = Yii::$app->request->post();

            if (!empty($post)) {
                $new_pass = $post['password'];
                $user->password = sha1($new_pass);

                if ($user->validate()) {
                    $user->save();
                    $link = '<a href="' . Url::toRoute('login') . '" class="" > Continue </a>';
                    return $this->render('notification', ['type' => 'success', 'message' => 'You have successfully changed your password. ' . $link . ' to login page.']);
                }
            } else {
                return $this->render('reset', ['url' => Url::toRoute('reset_password/' . $hash . '/' . $user_id)]);
            }
        }


    }

    /**
     * @return string
     */
    public function actionPassword_reset()
    {
        $this->layout = 'login';
        return $this->render('reset_password');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getModule('admin')->user->logout();

        return $this->redirect(Url::toRoute('login'));
    }
}

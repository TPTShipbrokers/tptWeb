<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'tpt',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6Kd3mqY9ERNxRU-3xY6KNq0lLOxqQ39E',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\models\WebUser',
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null
        ],

        'api' => [
            'class' => 'app\components\Api'

        ],
        'utils' => [
            'class' => 'app\components\Utils'

        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => [
                'api/<controller:\w+>/<action:\w+>/<params:\w+>' => 'api/<controller>/<action>',
                //'api/<controller:\w+>/<action:\w+>/<attribute:[\w_-\d]*>/<value:[\w_-\d]*>' => 'api/<controller>/<action>',
                'api/<controller:\w+>/<action:\w+>/<id:\d+>' => 'api/<controller>/<action>',
                // 'api/<controller:\w+>/<action:\w+>/<cond:[&\w_-\d=]*>' => 'api/<controller>/<action>',

                'admin/login' => 'admin/default/login',
                'admin/logout' => 'admin/default/logout',
                'admin/dashboard' => 'admin/default/dashboard',
                'admin/password_reset' => 'admin/default/password_reset',
                'admin/reset_password_request' => 'admin/default/reset_password_request',
                'admin/reset_password/<hash:\w+>/<user_id:\d+>' => 'admin/default/reset_password',


                'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<controller:[\w_-]+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>' => 'admin/<controller>/index',
                'admin' => 'admin/default',

                '<controller:\w+>/<id:\d+>' => '<controller>/index/<id>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',

                'user/password_reset/<token:\w+>' => 'user/password_reset',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',


            ],
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'positionHelper' => 'app\components\PositionHelper'
    ],
    'params' => $params,

    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*']
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['debug']['class'] = 'yii\debug\Module';
    $config['modules']['debug']['allowedIPs'] = ['127.0.0.1'];

    $config['bootstrap'][] = 'gii';

    $config['modules']['gii']['class'] = 'yii\gii\Module';
}

return $config;

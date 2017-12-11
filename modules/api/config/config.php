<?php
return [
    'id' => 'basic',

    'controllerNamespace' => 'app\modules\api\controllers',
    // TODO: skloniti
    //  'defaultRoute' => 'default/auth',

    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'rules' => [

            ]
        ],

        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'loginUrl' => null,
            'enableSession' => false
        ],

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=app',
            'username' => 'root',
            'password' => '11c9jVTDzH!11',
            'charset' => 'utf8',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

    ],
    'modules' => [

    ],

    'params' => [
        'adminEmail' => 'jovana.stefanovic.js@gmail.com',
    ]
];

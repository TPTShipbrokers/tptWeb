<?php
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'admin',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@admin' => dirname(__DIR__)
    ],

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [

            'class' => 'app\models\User',
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => '/admin/login'
        ],


        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [],
        ],

        'db' => require(__DIR__ . '/db.php'),

    ],
    'params' => $params,

];

return $config;

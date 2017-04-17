<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$baseUrl = str_replace('/web', '', (new \yii\web\Request)->getBaseUrl());

return [
    'id' => 'app-mainsite',
    'name' => 'Yii2 Members System',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'mainsite\controllers',
    'modules' => [],
    'components' => [
        'assetManager' => [
            'bundles' => false,
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => $baseUrl,
        ],
        'user' => [
            'class' => 'common\components\User',       // extend User component
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
                //'domain' => Yii::getAlias('@domainName'),     // uncomment for sub-domain use
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'cookieParams' => [
                'httpOnly' => true,
                //'domain' => Yii::getAlias('@domainName'),     // uncomment for sub-domain use
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            // comment out the following line for sub-domain use
            'baseUrl' => $baseUrl . '/../frontend',
            // uncomment the following line for sub-domain use
            //'hostInfo' => Yii::getAlias('@httpScheme') . '://' . Yii::getAlias('@frontendSubdomain') . '.' . Yii::getAlias('@domainName'),
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

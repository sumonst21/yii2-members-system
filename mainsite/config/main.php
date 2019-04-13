<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-mainsite',
    'name' => 'Yii2 Members System',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'mainsite\controllers',
    'components' => [
        'assetManager' => [
            'bundles' => false,
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'csrfCookie' => [
                'httpOnly' => true,
                'domain' => Yii::getAlias('@domainName'),       // uncomment for sub-domain use
            ],
        ],
        'user' => [
            'class' => 'common\components\UserComponent',       // custom User Component
            'identityClass' => 'common\models\User',            // custom User Identity Interface
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
                'domain' => Yii::getAlias('@domainName'),       // uncomment for sub-domain use
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'cookieParams' => [
                'httpOnly' => true,
                'domain' => Yii::getAlias('@domainName'),       // uncomment for sub-domain use
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:404'],
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
                'aff/<id:\d+>/<lp:\d+>' => 'affiliate/index',
                'aff/<id:\d+>' => 'affiliate/index',
                'landing/<id:\d+>' => 'landing/index',
                'lp/<id:\d+>' => 'landing/index',
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            // uncomment the following line for sub-domain use
            'hostInfo' => Yii::getAlias('@httpScheme') . '://' . Yii::getAlias('@frontendSubdomain') . '.' . Yii::getAlias('@domainName'),
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'affiliate' => [
            'class' => 'common\components\Affiliate',
            'cookieName' => 'affiliate_cookie',
            'cookieDuration' => 90,
            'cookieDomain' => Yii::getAlias('@domainName'),

            // redirectUrl must start with a `/` if pointing to a controller that
            // is not the affiliate controller!
            'redirectUrl' => '/site/index', // default is `affiliate/index`
        ],
    ],
    'params' => $params,
];

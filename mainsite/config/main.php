<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'app-mainsite',
    'name' => env('MAINSITE_APP_NAME', 'Yii2 Members System'),
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'mainsite\controllers',
    'modules' => [],
    'components' => [
        'view' => [
            'class' => 'common\components\View',                        // custom View class with signupLinkParams
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('FRONTEND_KEY'),
            'csrfCookie' => [
                'httpOnly' => true,
                'domain' => env('DOMAIN_NAME'),                         // required for sub-domain use
            ],
        ],
        'user' => [
            'class' => 'common\components\UserComponent',               // custom User Component
            'identityClass' => 'common\models\User',                    // custom User Identity Interface
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
                'domain' => env('DOMAIN_NAME'),                         // required for sub-domain use
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'cookieParams' => [
                'httpOnly' => true,
                'domain' => env('DOMAIN_NAME'),                         // required for sub-domain use
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require Yii::getAlias('@common/config/rules/mainsite-rules.php'),
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'hostInfo' => Yii::getAlias('@frontendDomain'),             // required for sub-domain use
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require Yii::getAlias('@common/config/rules/frontend-rules.php'),
        ],
        'affiliate' => require Yii::getAlias('@common/config/affiliate.php'),
    ],
    'params' => $params,
];

return $config;

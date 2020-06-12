<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'app-backend',
    'name' => env('BACKEND_APP_NAME', 'Yii2 Members System'),
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'modules' => [],
    'components' => [
        'view' => [
            'class' => 'common\components\View',                        // custom View class with bodyClasses
            //'showHeaderNotifications' => false,
            //'showHeaderMessages' => false,
            //'showHeaderTasks' => false,
            //'showHeaderControlSidebar' => false,
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('BACKEND_KEY'),
        ],
        'user' => [
            'class' => 'backend\components\AdminComponent',             // custom Admin Component
            'identityClass' => 'backend\models\Admin',                  // custom Admin Identity Interface
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require Yii::getAlias('@common/config/rules/backend-rules.php'),
        ],
        'urlManagerMainsite' => [
            'class' => 'yii\web\UrlManager',
            'hostInfo' => Yii::getAlias('@mainsiteDomain'),             // required for sub-domain use
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
        'assetManager' => [
            'bundles' => [
                'backend\assets\AdminLteAsset' => [
                    'skin' => 'skin-black',
                ],
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false, // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
    ],
    'params' => $params,
];

// We only need Gii available in the backend (admin) app
if (!YII_ENV_TEST && (YII_ENV === 'dev') && (YII_DEBUG === true) ) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

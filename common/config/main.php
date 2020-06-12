<?php

/**
 * @var array $config The global `config/main.php` used on everything (frontend, backend, mainsite, and console) and loaded first
 */
$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . env('DB_HOST') . ';port=' . env('DB_PORT', '3306') . ';dbname=' . env('DB_NAME'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASS'),
            'charset' => env('DB_CHARSET', 'utf8'),
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => env('MAIL_FILE_TRANSPORT', true),
            'transport' => [
                'class' => env('MAIL_CLASS', 'Swift_SmtpTransport'),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'host' => env('MAIL_HOST'),
                'port' => env('MAIL_PORT', 465),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
            ],
            'messageConfig' => [
                'charset' => env('MAIL_CHARSET', 'UTF-8'),
                'from' => [env('MAIL_FROM_ADDRESS', 'noreply@example.com') => env('MAIL_FROM_NAME', env('APP_NAME', 'Yii2') . ' Mailer')],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
    ],
];

if (!YII_ENV_TEST && (YII_ENV === 'dev') && (YII_DEBUG === true) ) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}

return $config;

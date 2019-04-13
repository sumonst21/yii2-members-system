<?php
$_package = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/package.json'), true);

return [
    'version' => $_package['version'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

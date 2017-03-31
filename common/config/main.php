<?php
$_package = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/package.json'), true);

return [
    'version' => $_package['version'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

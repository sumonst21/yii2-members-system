<?php
return [
    'id' => 'app-mainsite-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'user' => [
            'class' => 'common\components\User',       // extend User component
            'identityClass' => 'common\models\User',   // custom User Identity Interface
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];

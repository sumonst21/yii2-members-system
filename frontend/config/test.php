<?php
return [
    'id' => 'app-frontend-tests',
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

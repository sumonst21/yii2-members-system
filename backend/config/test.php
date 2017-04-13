<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'user' => [
            'class' => 'backend\components\User',       // extend User component
            'identityClass' => 'backend\models\Admin',  // custom Admin Identity Interface
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];

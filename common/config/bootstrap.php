<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@mainsite', dirname(dirname(__DIR__)) . '/mainsite');

// URL Manager Aliases
Yii::setAlias('@httpScheme', 'https');
Yii::setAlias('@domainName', (YII_ENV === 'dev') ? 'yii2-members-system.local' : 'yourlivesite.com');
Yii::setAlias('@frontendSubdomain', 'users');
Yii::setAlias('@backendSubdomain', 'admin');

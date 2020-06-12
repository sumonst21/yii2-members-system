<?php
Yii::setAlias('@common',   dirname(__DIR__));
Yii::setAlias('@console',  dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@backend',  dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@mainsite', dirname(dirname(__DIR__)) . '/mainsite');

Yii::setAlias('@appRoot', dirname(dirname(__DIR__)));

Yii::setAlias('@backendDomain',  getDomain( env('BACKEND_SUBDOMAIN',  'admin') ));
Yii::setAlias('@frontendDomain', getDomain( env('FRONTEND_SUBDOMAIN', 'users') ));
Yii::setAlias('@mainsiteDomain', getDomain( env('MAINSITE_SUBDOMAIN') ));

<?php
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../common/config/dotenv.php';

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', false));
defined('YII_ENV')   or define('YII_ENV',   env('YII_ENV',   'prod'));

require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';     // requires YII constants
require __DIR__ . '/../../common/config/bootstrap.php';     // requires Yii.php
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../config/main.php',
);

(new yii\web\Application($config))->run();

<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
          'migrate' => [
              'class' => 'yii\console\controllers\MigrateController',
              'templateFile' => '@console/migrations/templates/migration.php',
              'useTablePrefix' => true,
              'generatorTemplateFiles' => [
                  'create_table' => '@console/migrations/templates/createTableMigration.php',
                  'drop_table' => '@yii/views/dropTableMigration.php',
                  'add_column' => '@yii/views/addColumnMigration.php',
                  'drop_column' => '@yii/views/dropColumnMigration.php',
                  'create_junction' => '@yii/views/createTableMigration.php',
              ],
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];

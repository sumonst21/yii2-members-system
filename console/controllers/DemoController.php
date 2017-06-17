<?php
namespace console\controllers;

use Yii;
use yii\console\Exception;

use yii\db\Command;
use yii\db\Connection;
use yii\db\Query;
use yii\db\Schema;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class DemoController extends \yii\console\Controller
{

    public function actionReset()
    {
        $this->stdout("--> Resetting Demo Database...\n", Console::FG_GREEN);

        Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();
        $tables = Yii::$app->db->schema->getTableNames();

        foreach ($tables as $table) {
            echo " - delete: $table\n";
            Yii::$app->db->createCommand()->dropTable($table)->execute();
        }

        Yii::$app->db->createCommand("SET foreign_key_checks = 1")->execute();

        $this->stdout("--> Database Reset!\n", Console::FG_GREEN);

        $this->run('migrate/up', ['interactive' => false]);

        $this->stdout("--> Demo Reset Successful!\n", Console::FG_GREEN);

    }

}

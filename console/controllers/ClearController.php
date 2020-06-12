<?php
namespace console\controllers;

use Yii;
use yii\base\ErrorException;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;

class ClearController extends Controller
{
    const CONSOLE_NEWLINE = "\n";

    public function actionIndex()
    {
        echo '//TODO: This... :)' . self::CONSOLE_NEWLINE;
    }

    public function actionAllRuntime()
    {
        $dirs = [
            Yii::getAlias('@mainsite/runtime/cache'),
            Yii::getAlias('@mainsite/runtime/debug'),
            Yii::getAlias('@mainsite/runtime/logs'),
            Yii::getAlias('@mainsite/runtime/mail'),

            Yii::getAlias('@frontend/runtime/cache'),
            Yii::getAlias('@frontend/runtime/debug'),
            Yii::getAlias('@frontend/runtime/logs'),
            Yii::getAlias('@frontend/runtime/mail'),

            Yii::getAlias('@backend/runtime/cache'),
            Yii::getAlias('@backend/runtime/debug'),
            Yii::getAlias('@backend/runtime/logs'),
            Yii::getAlias('@backend/runtime/mail'),

            Yii::getAlias('@console/runtime/cache'),
            Yii::getAlias('@console/runtime/debug'),
            Yii::getAlias('@console/runtime/logs'),
        ];

        foreach ( $dirs as $dir ) {
            try
            {
                FileHelper::removeDirectory($dir);
                echo $this->ansiFormat('  - Deleted: ', Console::FG_YELLOW, Console::BOLD) . $dir . self::CONSOLE_NEWLINE;
            } catch ( ErrorException $e ) {
                echo $this->ansiFormat('  x Error Deleting: ', Console::FG_RED, Console::BOLD) . $dir . self::CONSOLE_NEWLINE;
            }
        }

        return ExitCode::OK;
    }

    public function actionAllAssets()
    {
        $dirs = [
            Yii::getAlias('@mainsite/web/assets'),
            Yii::getAlias('@frontend/web/assets'),
            Yii::getAlias('@backend/web/assets'),
        ];

        foreach ( $dirs as $dir ) {
            try
            {
                $assets = FileHelper::findDirectories($dir, ['recursive' => false]);

                foreach ( $assets as $asset )
                {
                    FileHelper::removeDirectory($asset);
                    echo $this->ansiFormat('  - Deleted: ', Console::FG_YELLOW, Console::BOLD) . $asset . self::CONSOLE_NEWLINE;
                }

            } catch ( ErrorException $e ) {
                echo $this->ansiFormat('  x Error Deleting: ', Console::FG_RED, Console::BOLD) . $asset . self::CONSOLE_NEWLINE;
            }
        }

        return ExitCode::OK;
    }

}

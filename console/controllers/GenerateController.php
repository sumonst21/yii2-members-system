<?php
namespace console\controllers;

use Yii;
use yii\base\ErrorException;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;

class GenerateController extends Controller
{
    const CONSOLE_NEWLINE = "\n";

    private $fileContent;

    private function getFileContent()
    {
        if ( isset($this->fileContent) && is_string($this->fileContent) && ! empty($this->fileContent) ) {
            return $this->fileContent;
        }

        $content = file_get_contents( Yii::getAlias('@appRoot/.env') );

        if ( isset($content) && is_string($content) && ! empty($content) ) {
            $this->fileContent = $content;
        }

        return $this->fileContent;
    }

    private function generate($length = 32)
    {
        return strtr(substr(base64_encode(openssl_random_pseudo_bytes($length)), 0, $length), '+/=', '_-.');
    }

    private function keysExist()
    {
        $content = $this->getFileContent();

        if ( isset($content) && is_string($content) && ! empty($content) ) {
            if ( (env('FRONTEND_KEY', null) !== null) && (env('BACKEND_KEY', null) !== null) ) {
                return true;
            }
        }

        return false;
    }

    private function frontendReplacementPattern()
    {
        $escaped = preg_quote('=' . env('FRONTEND_KEY', ''), '/');

        return "/^FRONTEND_KEY{$escaped}/m";
    }

    private function backendReplacementPattern()
    {
        $escaped = preg_quote('=' . env('BACKEND_KEY', ''), '/');

        return "/^BACKEND_KEY{$escaped}/m";
    }

    /*
     * Write the keys to the env file
     *
     * This does not care if they exist, it just does the job.
     */
    private function writeKeys()
    {
        $content = $this->getFileContent();

        $content = preg_replace(
            $this->frontendReplacementPattern(),
            'FRONTEND_KEY=' . $this->generate(),
            $content
        );

        $content = preg_replace(
            $this->backendReplacementPattern(),
            'BACKEND_KEY=' . $this->generate(),
            $content
        );

        $this->fileContent = $content;

        if ( file_put_contents(Yii::getAlias('@appRoot/.env'), $content) ) {
            return ExitCode::OK;
        }

        return ExitCode::UNSPECIFIED_ERROR;
    }

    public function actionIndex()
    {
        echo '//TODO: This... :)' . self::CONSOLE_NEWLINE;
    }
    
    public function actionKeys()
    {
        if ( $this->keysExist() )
        {
            echo '   Key generation aborted! Keys already exist!' . self::CONSOLE_NEWLINE;
            echo '   use "generate/new-keys" to force key generation!' . self::CONSOLE_NEWLINE;
            return ExitCode::USAGE;
        }

        $this->writeKeys();
    }

    public function actionNewKeys()
    {
        $this->writeKeys();
    }

}

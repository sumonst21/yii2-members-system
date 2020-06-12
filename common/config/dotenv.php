<?php
use yii\web\ServerErrorHttpException;

class YiiEnvException extends \Exception {

    public function __construct($message, $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        die( '<strong>Fatal Error:</strong> ' . $this->getMessage() );
    }
}

try {
    $dotenv = \Dotenv\Dotenv::createImmutable( dirname(dirname(__DIR__)) );
    $dotenv->load();

    $dotenv->required(['FRONTEND_KEY', 'BACKEND_KEY', 'DB_PASS', 'MAINSITE_SUBDOMAIN', 'APP_NAME', 'MAINSITE_APP_NAME', 'FRONTEND_APP_NAME', 'BACKEND_APP_NAME']);
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_CHARSET', 'DOMAIN_NAME', 'FRONTEND_SUBDOMAIN', 'BACKEND_SUBDOMAIN'])->notEmpty();
    $dotenv->required('YII_DEBUG')->isBoolean();
    $dotenv->required('YII_ENV')->allowedValues(['dev', 'test', 'stage', 'prod']);

} catch ( \Dotenv\Exception\InvalidPathException $e ) {

    throw new YiiEnvException('DotEnv Invalid Path!');

} catch ( \Dotenv\Exception\InvalidFileException $e ) {

    throw new YiiEnvException('DotEnv Invalid File!');

} catch ( \Dotenv\Exception\ValidationException $e ) {

    throw new YiiEnvException('DotEnv Invalid Validation! ' . $e->getMessage());

}

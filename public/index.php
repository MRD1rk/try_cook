<?php

use Phalcon\Di\FactoryDefault;
define('BASE_PATH',__DIR__);
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CRYPT_KEY','asf456Jrert');
define('ENVIRONMENT', 'development');
//define('ENVIRONMENT', 'production');

if (!defined('ENVIRONMENT')) {
    exit('The application environment is not defined.');
}
date_default_timezone_set('Europe/Kiev');
switch (ENVIRONMENT) {
    case 'development':
        ini_set('display_errors', 'On');
        ini_set('display_startup_errors', 'On');
        ini_set('error_reporting', 'E_ALL');
        ini_set('log_errors', 'On');
        error_reporting(E_ALL);
        break;
    case 'production':
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', 'Off');
        ini_set('error_reporting', '0');
        ini_set('log_errors', 'On');
        break;
}
try {

    require_once('../vendor/autoload.php');
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);


    /**
     * Include modules
     */
    require __DIR__ . '/../app/config/modules.php';
    (new Phalcon\Debug)->listen();
    echo $application->handle()->getContent();
//    echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}

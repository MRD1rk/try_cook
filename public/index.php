<?php

use Phalcon\Di\FactoryDefault;

//if(!in_array($_SERVER['REMOTE_ADDR'],['93.73.241.71','95.164.50.26'])){
//    die('exit');
//}
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

define('ENVIRONMENT', 'development');
//define('ENVIRONMENT', 'production');

if (!defined('ENVIRONMENT')) {
    exit('The application environment is not defined.');
}
ini_set( 'session.cookie_domain', $_SERVER['HTTP_HOST']);
session_set_cookie_params (0, '/', $_SERVER['HTTP_HOST'], false);
session_start();
setcookie('PHPSESSID', session_id(), time()+60*60*24*30, '/', $_SERVER['HTTP_HOST'], false, true);
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

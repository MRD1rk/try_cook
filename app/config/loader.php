<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->modelsDir
    ]
);
$loader->registerNamespaces([
    'Models' => APP_PATH.'/models'
]);
$loader->registerClasses([
    'BackendRoutes' => APP_PATH . '/config/BackendRoutes.php',
    'FrontendRoutes' => APP_PATH . '/config/FrontendRoutes.php',
    'ApiRoutes' => APP_PATH . '/config/ApiRoutes.php',
//    'Models\Configuration' => APP_PATH . '/models/Configuration.php',
]);
$loader->register();

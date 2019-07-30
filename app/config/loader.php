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
$loader->registerClasses([
    'BackendRoutes' => APP_PATH . '/config/BackendRoutes.php',
    'FrontendRoutes' => APP_PATH . '/config/FrontendRoutes.php',
]);
$loader->register();

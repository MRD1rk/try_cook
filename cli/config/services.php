<?php

use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data as FrontData;
/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();
    return new \Phalcon\Db\Adapter\Pdo\Mysql(
        [
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname,
            'charset' => $config->database->charset
        ]
    );
});
$di->setShared('dispatcher', function () {
    $dispatcher = new Phalcon\CLI\Dispatcher();
    $dispatcher->setDefaultNamespace('Tasks');
    return $dispatcher;
});


<?php

use Models\Translate;
use Phalcon\Logger\Factory;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data as FrontData;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'charset' => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});


/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Set up the flash session service as flash
 */
$di->set('flash', function () {
    $flash = new \Overwrite\FlashSession([
        "error" => "alert alert-danger",
        "success" => "alert alert-success",
        "notice" => "alert alert-info",
        "warning" => "alert alert-warning",
    ]);
    $flash->setAutoescape(false);
    return $flash;
});

$di->setShared('cookies', function () {
    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;
});
$di->setShared('crypt', function () {
    $crypt = new \Phalcon\Crypt();
    $crypt->setCipher('aes-256-ctr');
    $crypt->setKey(CRYPT_KEY);
    $crypt->useSigning(true);
    return $crypt;
});

/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new \Phalcon\Mvc\Router();
    $router->setDefaultModule('frontend');
    $router->mount(new FrontendRoutes());
    $router->mount(new BackendRoutes());
    $router->mount(new ApiRoutes());
    $router->removeExtraSlashes(true);
    $router->handle();
    return $router;
});
$di->setShared('t', function () {
    $translates = Translate::getTranslates();
    return new \Phalcon\Translate\Adapter\NativeArray(
        [
            'content' => $translates
        ]
    );
});

$di->setShared('redis', function () {
    $redis = new Redis(
        new FrontData(['lifetime' => 60]),
        [
            "host" => "localhost",
            "port" => 6379,
            "auth" => "",
            "persistent" => false,
        ]);
//    $redis = new \Redis();
//    $redis->connect('localhost');
//    for ($i=0;$i<=10000;$i++){
//        $redis->setBit('size_2',$i,rand(0,1));
//        $redis->setBit('weight_2',$i,rand(0,1));
//    }
//    $redis->bitOp('OR','result','weight_2','size_2');
//    $r = $redis->get('result');
//    $bytes = unpack('C*', $r);
//    $bin = join(array_map(function($byte){
//        return sprintf("%08b", $byte);
//    }, $bytes));
//    echo '<pre>';
//    var_dump($bin);
//    die();
//    return $bin;
    return $redis;
});
$di->setShared('url', function () {
    $urlManager = new \Components\UrlManager();
    return $urlManager;
});
$di->setShared('tag',function (){
   $tag = new \Overwrite\Tag();
   return $tag;
});
$di->setShared('logger',function (){
    $options = [
        'name'    => 'log.txt',
        'adapter' => 'file',
    ];
    $logger = Phalcon\Logger\Factory::load($options);
    return $logger;
});


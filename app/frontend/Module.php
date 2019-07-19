<?php

namespace Modules\Frontend;

use Phalcon\DiInterface;
use Phalcon\Dispatcher;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

class Module
{
    public function __construct()
    {
    }

    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
            'Models' => __DIR__ . '/../models/',
            'Modules\Frontend\Forms' => __DIR__ . '/forms/',
            'Modules\Frontend\Plugins' => __DIR__ . '/plugins/',
            'Modules\Frontend\Components' => __DIR__ . '/components/',
            'Modules\Frontend\Widgets' => __DIR__ . '/widgets/',
        ));

        $loader->register();
    }

    /**
     * Registers the module-only services
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $di['dispatcher'] = function () use ($di) {
            $eventsManager = $di->getShared('eventsManager');
            /**
             * Check if the user is allowed to access certain action using the SecurityPlugin
             */
            $eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(
                            array(
                                'controller' => 'error',
                                'action' => 'show404',
                            )
                        );
                        return false;
                }
            });
//            $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin());
            $dispatcher = new \Phalcon\Mvc\Dispatcher();

            $dispatcher->setDefaultNamespace('Modules\Frontend\Controllers');
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        };
        $di->set('view', function () {

            $view = new View();

            $view->registerEngines(array(
                ".volt" => 'volt'
            ));
            $view->setViewsDir(__DIR__ . '/views/');
            $view->setLayoutsDir('../views/layouts/');
            $view->setLayout('main');
            return $view;
        });

        $di->set('volt', function ($view, $di) {

            $volt = new Volt($view, $di);

            $volt->setOptions(array(
                "compiledPath" => __DIR__ . "/views/cache/",
                'compileAlways' => true
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFunction('is_a', 'is_a');
            $compiler->addFunction('floor', 'floor');
            $compiler->addFunction('strtotime', 'strtotime');
            return $volt;
        }, true);
    }
}
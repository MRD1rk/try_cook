<?php

namespace Modules\Api;

use Models\Context;
use Phalcon\Assets\Manager;
use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
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
            'Modules\Api\Controllers' => __DIR__ . '/controllers/',
            'Models' => __DIR__ . '/../models/',
            'Components' => __DIR__ . '/../components/',
            'Helpers' => __DIR__ . '/../helpers/',
            'Overwrite' => __DIR__ . '/../overwrite/',
            'Modules\Api\Forms' => __DIR__ . '/forms/',
            'Modules\Api\Plugins' => __DIR__ . '/plugins/',
            'Modules\Api\Components' => __DIR__ . '/components/',
            'Modules\Api\Widgets' => __DIR__ . '/widgets/',
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
        $di->set('dispatcher', function () use ($di) {
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
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace('Modules\Api\Controllers');
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        },true);

        $di->setShared(
            'response',
            function () {
                $response = new \Phalcon\Http\Response();
                $response->setContentType('application/json', 'utf-8');

                return $response;
            }
        );
        $di->set('view', function () {

            $view = new View();

//            $view->setRenderLevel(
//                View::LEVEL_ACTION_VIEW
//            );
//            $view->setViewsDir(__DIR__ . '/views/');
//            $view->setLayoutsDir('../views/layouts/');
//            $view->setLayout('main');
            return $view;
        });


        $di->set('context', function () {
            return Context::getInstance();
        });
    }
}
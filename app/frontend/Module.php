<?php

namespace Modules\Frontend;

use Helpers\Converter;
use Models\Context;
use Modules\Frontend\Widgets\BreadCrumbsWidget;
use Modules\Frontend\Widgets\NavWidget;
use Modules\Frontend\Widgets\PopularRecipesWidget;
use Modules\Frontend\Widgets\SelectLangWidget;
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
            'Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
            'Models' => __DIR__ . '/../models/',
            'Components' => __DIR__ . '/../components/',
            'Helpers' => __DIR__ . '/../helpers/',
            'Overwrite' => __DIR__ . '/../overwrite/',
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

            $dispatcher->setDefaultNamespace('Modules\Frontend\Controllers');
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        },true);

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
                "compiledPath" => __DIR__ . "/views/.cache/",
                'compileAlways' => true
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFunction('is_a', 'is_a');
            $compiler->addFunction('floor', 'floor');
            $compiler->addFunction('strtotime', 'strtotime');
            return $volt;
        }, true);
        $di->set('converter',function (){
            $converter = new Converter();
            return $converter;
        });
        $di->set('assets', function () {
            $assets = new Manager();
            $assets->collection('headerCss')
                ->addCss('vendor/bootstrap/css/bootstrap.min.css')
                ->addCss('vendor/font-awesome/css/all.min.css?v=1')
                ->addCss('css/fonts.css')
                ->addCss('css/custom.css');
            $assets->collection('footerJs')
                ->addJs('vendor/jquery/jquery.min.js')
                ->addJs('vendor/bootstrap/js/bootstrap.bundle.min.js')
                ->addJs('vendor/jquery-easing/jquery.easing.min.js')
                ->addJs('js/custom.js')
//                ->join(true)
//                ->setTargetPath('js/application.min.js')
//                ->setTargetUri('js/application.min.js')
//                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            ;

            return $assets;
        }, true);

        $di->set('context', function () {
            return Context::getInstance();
        });
        $di->set('NavWidget', function () {
            return new NavWidget();
        });
        $di->set('BreadCrumbsWidget', function () {
            return new BreadCrumbsWidget();
        });
        $di->set('SelectLangWidget', function () {
            return new SelectLangWidget();
        });
        $di->set('PopularRecipesWidget', function () {
            return new PopularRecipesWidget();
        });
    }
}
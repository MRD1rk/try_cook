<?php


namespace Modules\Backend;

use Components\Auth;
use Models\Context;
use Modules\Backend\Plugins\PersistentLoginPlugin;
use Modules\Backend\Plugins\SecurityPlugin;
use Modules\Backend\Widgets\AdminNavWidget;
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
            'Modules\Backend\Controllers' => __DIR__ . '/controllers/',
            'Models' => __DIR__ . '/../models/',
            'Components' => __DIR__ . '/../components/',
            'Helpers' => __DIR__ . '/../helpers/',
            'Overwrite' => __DIR__ . '/../overwrite/',
            'Modules\Backend\Forms' => __DIR__ . '/forms/',
            'Modules\Backend\Plugins' => __DIR__ . '/plugins/',
            'Modules\Backend\Components' => __DIR__ . '/components/',
            'Modules\Backend\Widgets' => __DIR__ . '/widgets/',
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
            $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin());
//            $eventsManager->attach('dispatch:beforeDispatch', new PersistentLoginPlugin());
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace('Modules\Backend\Controllers');
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        }, true);

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

        $di->set('auth',function () {
            $options = [
                'rememberMeDuration' => 1096000 // Optional, default: 604800 (1 week)
            ];
            return new Auth(new \Models\Employee(), $options);
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

        $di->set('assets', function () {
            $assets = new Manager();
            $assets->collection('headerCss')
                ->addCss('/admin-theme/css/bootstrap.min.css')
                ->addCss('/admin-theme/css/font-awesome.min.css')
                ->addCss('/admin-theme/css/themify-icons.css')
                ->addCss('/admin-theme/css/metisMenu.css')
                ->addCss('/admin-theme/css/owl.carousel.min.css')
                ->addCss('/admin-theme/css/slicknav.min.css')
                ->addCss('/admin-theme/css/typography.css')
                ->addCss('/admin-theme/css/default-css.css')
                ->addCss('/admin-theme/css/global.css')
                ->addCss('/admin-theme/css/styles.css')
                ->addCss('/admin-theme/css/responsive.css');
            $assets->collection('footerJs')
                ->addJs('/admin-theme/js/vendor/modernizr-2.8.3.min.js')
                ->addJs('/admin-theme/js/vendor/jquery-2.2.4.min.js')
                ->addJs('/admin-theme/js/popper.min.js')
                ->addJs('/admin-theme/js/bootstrap.min.js')
                ->addJs('/admin-theme/js/global.js')
                ->addJs('/admin-theme/js/owl.carousel.min.js')
                ->addJs('/admin-theme/js/metisMenu.min.js')
                ->addJs('/admin-theme/js/jquery.slimscroll.min.js')
                ->addJs('/admin-theme/js/jquery.slicknav.min.js')
                ->addJs('/admin-theme/js/chart.min.js')
                ->addJs('/admin-theme/js/highcharts.js')
                ->addJs('/admin-theme/js/highcharts-exporting.js')
                ->addJs('/admin-theme/js/highcharts-export-data.js')
                ->addJs('/admin-theme/js/pie-chart.js')
                ->addJs('/admin-theme/js/bar-chart.js')
                ->addJs('/admin-theme/js/plugins.js')
                ->addJs('/admin-theme/js/scripts.js');

            return $assets;
        }, true);

        $di->set('context', function () {
            return Context::getInstance();
        });
        $di->set('AdminNavWidget', function () {
            return new AdminNavWidget();
        });
    }
}
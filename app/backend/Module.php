<?php


namespace Modules\Backend;

use Components\Auth;
use Models\Context;
use Modules\Backend\Plugins\PersistentLoginPlugin;
use Modules\Backend\Plugins\SecurityPlugin;
use Modules\Backend\Widgets\AdminNavWidget;
use Modules\Backend\Widgets\AdminSidebarWidget;
use Modules\Backend\Widgets\BreadCrumbsWidget;
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

            $eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) {
                //Handle 404 exceptions

                if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
                    $dispatcher->forward(array(
                        'controller' => 'errors',
                        'action' => 'show404'
                    ));
                    return false;
                }
            });
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
            $compiler->addFilter('def',  function($args_list) use ($di) {
                $args = explode(", ", $args_list);
                return "(isset($args[0]) ? $args[0] : $args[1])";
            });
            return $volt;
        }, true);

        $di->set('assets', function () {
            $assets = new Manager();
            $assets->collection('headerCss')
                ->addCss('/vendor/bootstrap/css/bootstrap.min.css')
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
                ->addJs('/vendor/jquery/jquery.min.js')
                ->addJs('/admin-theme/js/library/popper.min.js')
                ->addJs('/vendor/bootstrap/js/bootstrap.bundle.min.js')
                ->addJs('/admin-theme/js/global.js')
                ->addJs('/admin-theme/js/library/owl.carousel.min.js')
                ->addJs('/admin-theme/js/library/metisMenu.min.js')
                ->addJs('/admin-theme/js/library/jquery.slimscroll.min.js')
                ->addJs('/admin-theme/js/library/jquery.slicknav.min.js')
                ->addJs('/admin-theme/js/library/chart.min.js')
                ->addJs('/admin-theme/js/library/highcharts.js')
                ->addJs('/admin-theme/js/library/highcharts-exporting.js')
                ->addJs('/admin-theme/js/library/highcharts-export-data.js')
                ->addJs('/admin-theme/js/library/pie-chart.js')
                ->addJs('/admin-theme/js/library/bar-chart.js')
                ->addJs('/admin-theme/js/library/plugins.js')
                ->addJs('/admin-theme/js/library/scripts.js');

            return $assets;
        }, true);

        $di->set('context', function () {
            return Context::getInstance();
        });
        $di->set('AdminNavWidget', function () {
            return new AdminNavWidget();
        });
        $di->set('AdminSidebarWidget', function () {
            return new AdminSidebarWidget();
        });
        $di->set('BreadCrumbsWidget', function () {
            return new BreadCrumbsWidget();
        });
    }
}
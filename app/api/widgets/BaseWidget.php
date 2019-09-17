<?php

namespace Modules\Frontend\Widgets;

use Components\UrlManager;
use Models\Context;
use Phalcon\Di;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Exception;
use Phalcon\Mvc\View;

/**
 * @property UrlManager url
 */
class BaseWidget
{
    protected $di;
    protected $view;
    protected $view_dir = '';
    protected $partial_path = '';

    public function __construct()
    {
        $this->view = $this->getView();
        $this->view->widget = $this;
        $this->view->iso_code = Context::getInstance()->getLang()->iso_code;
    }

    public function render($partial_path)
    {
        $this->partial_path = $partial_path;
        if ($this->view_dir)
            $this->partial_path = $this->view_dir . '/' . $partial_path;
        return $this->view->getPartial($this->partial_path);
    }


    public function getView()
    {
        if ($this->view) {
            return $this->view;
        }

        $view = new View();

        $view->registerEngines(
            [
                ".volt" => "volt",
            ]
        );

        $eventsManager = new EventsManager();
        $eventsManager->attach("view", function ($event, $view) {
            if ($event->getType() == 'notFoundView') {
                throw new Exception('View not found' . $view->getActiveRenderPath());
            }
        });
        $view->setViewsDir(__DIR__ . '/views/');
        $view->setEventsManager($eventsManager);
        $view->setDI($this->getDi());

        $this->view = $view;
        return $this->view;
    }

    /**
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return Di::getDefault();
    }
}
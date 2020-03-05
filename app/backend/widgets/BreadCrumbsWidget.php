<?php

namespace Modules\Backend\Widgets;

class BreadCrumbsWidget extends BaseWidget
{
    protected $view_dir = 'breadcrumbs';

    public function run($view = 'nav')
    {
        $router = $this->getDi()->get('router');
        $controller_name = $router->getControllerName();
        $action_name = $router->getActionName();
        $links = [];
        if ($controller_name !== 'index') {
            $links[] = [
                'link' => $this->getDi()->getUrl()->get(['for' => 'admin-index-index']),
                'name' => $this->getDi()->getT()->_('to_main')
            ];
        }
        if ($action_name !== 'index') {
            $links[] = [
                'link' => $this->getDi()->getUrl()->get(['for' => 'admin-' . $controller_name . '-index']),
                'name' => $this->getDi()->getT()->_($controller_name . '_index')
            ];
        }


        if ($router->getMatchedRoute()->getName()) {
            $links[] = [
                'link' => $this->getDi()->getUrl()->get(['for' => $router->getMatchedRoute()->getName()]),
                'name' => $this->getDi()->getT()->_($controller_name . '_' . $action_name)
            ];
        }
        $this->view->breadcrumbs = $links;
        return $this->render($view);

    }

}
<?php


namespace Modules\Backend\Widgets;


use Models\AdminMenu;
use Models\Context;

class AdminMenuWidget extends BaseWidget
{
    protected $view_dir = 'admin-menu';

    public function run($view = 'left-sidebar')
    {
        $dispatcher = $this->getDi()->getDispatcher();

        $id_role = Context::getInstance()->getEmployee()->getIdRole();
        $tabs = AdminMenu::find([
            'conditions' => 'id_parent = 0 AND id_role = ' . $id_role,
            'order' => 'position'
        ]);
        $this->view->tabs = $tabs;
        $this->view->action = $dispatcher->getActionName();
        $this->view->controller = $dispatcher->getControllerName();
        return $this->render($view);
    }
}
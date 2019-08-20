<?php


namespace Modules\Backend\Widgets;


use Models\AdminMenu;
use Models\Context;

class AdminNavWidget extends BaseWidget
{
    protected $view_dir = 'admin-nav';


    public function renderLeftMenu($view = 'left-sidebar')
    {
        $dispatcher = $this->getDi()->getDispatcher();
        $id_role = Context::getInstance()->getEmployee()->getIdRole();
        $tabs = AdminMenu::find([
            'conditions' => 'active = 1 AND id_parent = 0 AND id_role = ' . $id_role,
            'order' => 'position'
        ]);
        $this->view->tabs = $tabs;
        $this->view->action = $dispatcher->getActionName();
        $this->view->controller = $dispatcher->getControllerName();
        return $this->render($view);
    }

    public function renderAccountNav($view = 'account-nav')
    {
        $employee = Context::getInstance()->getEmployee();
        $logged = $employee->getLogged();
        if (!$logged)
            return '';
        $this->view->employee = $employee;
        return $this->render($view);
    }
}
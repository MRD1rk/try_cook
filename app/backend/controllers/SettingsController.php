<?php


namespace Modules\Backend\Controllers;


use Models\AdminMenu;

class SettingsController extends BaseController
{
    public function initialize()
    {
        
    }

    public function actionIndex()
    {
        
    }

    public function actionAccessControl()
    {

    }

    public function actionMenuControl()
    {
        $menu_items = AdminMenu::find();
        $this->view->menu_items = $menu_items;
    }
}
<?php


namespace Modules\Backend\Controllers;


use Models\AdminMenu;

class SettingsController extends BaseController
{
    public function initialize()
    {

    }

    public function indexAction()
    {

    }

    public function actionAccessControl()
    {

    }

    public function adminMenuAction()
    {
        $this->assets->collection('footerJs')
            ->addJs('/admin-theme/js/vendor/vakata-jstree/dist/jstree.min.js')
            ->addJs('/js/settings.js');
        $this->assets->collection('headerCss')->addCss('/admin-theme/js/vendor/vakata-jstree/dist/themes/default/style.min.css');
        $menu_items = AdminMenu::find('id_parent = 0');
        $this->view->menu_items = $menu_items;
    }
}
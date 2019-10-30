<?php


namespace Modules\Backend\Widgets;

class AdminSidebarWidget extends BaseWidget
{

    protected $view_dir = 'admin-sidebar';

    public function run($view, $id = null)
    {
        if (!$view)
            return '';
        $this->view->id = $id;
        return $this->render($view);
    }
}
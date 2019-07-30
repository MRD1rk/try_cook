<?php


namespace Modules\Frontend\Widgets;


class NavWidget extends BaseWidget
{
    protected $view_dir = 'nav';

    public function run($view = 'header', $navs = null)
    {
        if (!$navs)
            return null;
        $this->view->navs = $navs;
        return $this->render($view);
    }
}
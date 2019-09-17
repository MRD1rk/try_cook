<?php


namespace Modules\Frontend\Widgets;


class NavWidget extends BaseWidget
{
    protected $view_dir = 'nav';

    public function run($view = 'header')
    {
        return $this->render($view);
    }
}
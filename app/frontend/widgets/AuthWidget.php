<?php


namespace Modules\Frontend\Widgets;


class AuthWidget extends BaseWidget
{
    public $view_dir = 'auth';

    public function run($template = 'header')
    {
        return $this->render($template);
    }
}
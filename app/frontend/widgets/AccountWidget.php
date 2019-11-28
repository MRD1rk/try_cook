<?php


namespace Modules\Frontend\Widgets;


use Models\Context;

class AccountWidget extends BaseWidget
{
    public $view_dir = 'account';

    public function run($template)
    {
        $user = Context::getInstance()->getUser();
        $this->view->user = $user;
        return $this->render($template);
    }
}
<?php


namespace Modules\Frontend\Controllers;


class ErrorsController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->container_class = 'container';
    }
    public function show404Action()
    {
    }

    public function csrfAction()
    {
    }
}
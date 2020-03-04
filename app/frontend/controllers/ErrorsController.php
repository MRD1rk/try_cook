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
        $this->response->setStatusCode(404);
    }

    public function csrfAction()
    {
        $this->response->setStatusCode(400);
    }
}
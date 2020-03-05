<?php


namespace Modules\Backend\Controllers;


class ErrorsController extends BaseController
{
    public function show404Action()
    {
        $this->response->setStatusCode(404);
    }

    public function show401Action()
    {
        $this->response->setStatusCode(401);
    }
}
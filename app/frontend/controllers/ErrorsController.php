<?php


namespace Modules\Frontend\Controllers;


class ErrorsController extends BaseController
{
    public function show404Action()
    {
        $this->container_class = 'container';
    }
}
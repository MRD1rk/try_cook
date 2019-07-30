<?php

namespace Modules\Frontend\Controllers;


class IndexController extends ControllerBase
{

    public function indexAction()
    {
    }

    public function signinAction()
    {
        $data = $this->request->getPost();
    }

}


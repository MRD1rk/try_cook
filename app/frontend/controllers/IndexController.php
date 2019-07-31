<?php

namespace Modules\Frontend\Controllers;


class IndexController extends ControllerBase
{

    public function indexAction()
    {
    }

    public function signinAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            echo '<pre>';
            var_dump($data);
            die();
        }
    }

}


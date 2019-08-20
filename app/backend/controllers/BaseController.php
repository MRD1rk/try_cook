<?php

namespace Modules\Backend\Controllers;

use Models\Context;
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function initialize()
    {
        $logged = Context::getInstance()->getEmployee()->getLogged();
        $this->view->current_uri = $this->router->getRewriteUri();
        $this->view->logged = $logged;
    }
}
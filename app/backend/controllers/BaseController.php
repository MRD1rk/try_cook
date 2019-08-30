<?php

namespace Modules\Backend\Controllers;

use Models\Configuration;
use Models\Context;
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function initialize()
    {
        $prefix = '/' . Configuration::get('ADMIN_PREFIX');
        $logged = Context::getInstance()->getEmployee()->getLogged();
        $this->view->logged = $logged;
        $this->view->prefix = $prefix;
    }
}
<?php

namespace Modules\Backend\Controllers;

use Models\Configuration;
use Models\Context;
use Models\Lang;
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function initialize()
    {
        $prefix = '/' . Configuration::get('ADMIN_PREFIX');
        $logged = Context::getInstance()->getEmployee()->getLogged();
        $activeLangs = Lang::find('active = 1');
        $this->view->logged = $logged;
        $this->view->langs = $activeLangs;
        $this->view->prefix = $prefix;
    }
}
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
        $this->assets->collection('footerJs')->addJs('admin-theme/js/translationApp.js');
        $prefix = '/' . Configuration::get('ADMIN_PREFIX');
        $logged = Context::getInstance()->getEmployee()->getLogged();
        $activeLangs = Lang::find('active = 1');
        $this->view->logged = $logged;
        $this->view->iso_code = $this->context->getLang()->iso_code;
        $this->view->langs = $activeLangs;
        $this->view->prefix = $prefix;
    }
}
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
        $this->tag->setTitle($this->t->_('admin_tag'));
        $action = $this->dispatcher->getActionName();
        $controller = $this->dispatcher->getControllerName();
        $this->tag->appendTitle($this->t->_($controller.'_'.$action));
        $this->assets->collection('footerJs')->addJs('admin-theme/js/translationApp.js');
        $prefix = '/' . Configuration::get('ADMIN_PREFIX');
        $logged = Context::getInstance()->getEmployee()->getLogged();
        $lang = Context::getInstance()->getLang();
        $activeLangs = Lang::find('active = 1');
        $this->view->logged = $logged;
        $this->view->iso_code = $this->context->getLang()->iso_code;
        $this->view->langs = $activeLangs;
        $this->view->lang = $lang;
        $this->view->prefix = $prefix;
    }
}
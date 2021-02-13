<?php

namespace Modules\Frontend\Controllers;

use Models\Configuration;
use Models\Context;
use Phalcon\Mvc\Controller;

/**
 * @property Context context
 */
class BaseController extends Controller
{

    public function initialize()
    {
        $session = $this->getDI()->get('session');
        $tokenKey = $session->get('csrf_token_key');
        $tokenValue = $session->get('csrf_token');
        try {
            $this->checkAuth();
        } catch (\Exception $e) {
        }
        $this->assets->collection('footerJs')->addJs('js/translationApp.js?v=1');
        $this->view->container_class = '';
        $this->view->t = $this->getDI()->get('t');
        $this->view->iso_code = $this->context->getLang()->getIsoCode();
        $this->view->tokenKey = $tokenKey;
        $this->view->tokenValue = $tokenValue;
        $this->view->site_name = Configuration::get('SITE_NAME');
    }

    public function checkAuth()
    {
        if (!$this->auth->getIdentity() && $this->auth->hasRememberMe())
            return $this->auth->loginWithRememberMe();
    }
}

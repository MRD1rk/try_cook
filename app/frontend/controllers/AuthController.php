<?php


namespace Modules\Frontend\Controllers;

use Models\User;
use Modules\Frontend\Forms\SignupForm;

class AuthController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->container_class = 'container';
    }

    public function signupAction()
    {
        $user = new User();
        $error = false;
        $form = new SignupForm();
        if ($this->request->isPost()){
            $post = $this->request->getPost();
            if (!$form->isValid($post)){
                $error = true;

            }
        }
        $this->view->has_error = $error;
        $this->view->form = $form;
    }

    public function signinAction()
    {

    }

    public function logoutAction()
    {

    }
}
<?php

namespace Modules\Frontend\Controllers;


use Models\User;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $this->view->container_class = 'container-fluid';
    }

    public function signupAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $user = new User();
            if ($user->save($data)) {
                $this->flash->success($this->t->_('welcome', ['name' => $user->getFullName()]));
            } else {
                foreach ($user->getMessages() as $message) {
                    echo  $message->getMessage();
                }
            }
        }
    }

    public function signinAction()
    {
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = User::findFirstByEmail($email);
            if ($user && $user->login($password)) {

            }
        }
    }

}


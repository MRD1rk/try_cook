<?php


namespace Modules\Backend\Controllers;


class IndexController extends BaseController
{
    public function indexAction()
    {
    }

    public function loginAction()
    {
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email', 'email');
            $password = $this->request->getPost('password');
            $remember_me = $this->request->getPost('remember_me', null, null);
            $auth = $this->auth;
            try {
                $auth->login($email, $password, $remember_me);
                $this->flash->success('welcome');
                return $this->response->redirect($this->url->get(['for' => 'admin-index-index']));
            } catch (\Exception $exception) {
                $this->flash->error($exception->getMessage());
            }

        }
    }

    public function logoutAction()
    {
        if ($this->auth->logout())
            return $this->response->redirect($this->url->get(['for' => 'admin-index-index']));

    }
}
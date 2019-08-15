<?php


namespace Modules\Backend\Controllers;


use Models\Employee;

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
            $employee = Employee::findFirstByEmail($email);
            if ($employee && $employee->login($password)) {

            }
        }
    }
}
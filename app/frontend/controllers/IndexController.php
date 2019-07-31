<?php

namespace Modules\Frontend\Controllers;


use Models\User;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
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

}


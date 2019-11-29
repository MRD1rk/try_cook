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
        $error = false;
        $messages = [];
        $form = new SignupForm();
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            if (!$form->isValid($post)) {
                $error = true;
            } else {
                $user = new User();
                $user->setFirstname($post['firstname']);
                $user->setLastname($post['lastname']);
                $user->setEmail($post['email']);
                $user->setPassword($post['password']);
                if (!$user->save()) {
                    foreach ($user->getMessages() as $error_message) {
                        $messages[] = $this->t->_($error_message->getMessage());
                    }
                } else {
                    $this->auth->check($post);
                    $this->flash->success($this->t->_('welcome', ['name' => $user->getFullName()]));
                    return $this->response->redirect($this->url->get(['for' => 'index-index']));
                }
            }
        }
        $this->view->has_error = $error;
        $this->view->messages = $messages;
        $this->view->form = $form;
    }

    public function signinAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = true;
            $post = $this->request->getPost();
            try {
                $this->auth->check($post);
                $message = 'welcome';
            } catch (\Exception $e) {
                $status = false;
                $message = $this->t->_($e->getMessage());
            }
            $response = [
                'status' => $status,
                'message' => $message
            ];
            return $this->response->setJsonContent($response);
        }
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();
        return $this->response->redirect('/');
    }
}
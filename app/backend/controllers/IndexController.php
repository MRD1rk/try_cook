<?php


namespace Modules\Backend\Controllers;


use Helpers\Tools;
use Models\Translate;

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

    public function transliterationAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $value = $this->request->getPost('value','string');
            if ($value){
                $status = true;
                $message = $this->t->_('successfully_generated');
                $content = Tools::strToUrl($value);
            } else{
                $status = false;
                $message = $this->t->_('string_is_required');
                $content = '';
            }
            $response = [
                'status' =>$status,
                'message' => $message,
                'content'=> $content
            ];
            return $this->response->setJsonContent($response);
        }
    }


    public function getTranslationsAction()
    {
        if ($this->request->isAjax()) {
            $status = false;
            $data = null;
            $category = $this->request->getPost('category');
            $translations = Translate::getTranslationsByCategory($category);
            if ($translations) {
                $status = true;
                $data = $translations;
            }
            return $this->response->setJsonContent(['status' => $status, 'data' => $data]);
        }
    }
}
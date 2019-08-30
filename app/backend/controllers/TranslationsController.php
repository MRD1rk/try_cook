<?php


namespace Modules\Backend\Controllers;


use Helpers\Tools;
use Models\Lang;
use Models\Translate;
use Models\TranslateLang;

class TranslationsController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $translations = Translate::find();
        $langs = Lang::find('active = 1');
        $this->view->translations = $translations;
        $this->view->langs = $langs;
    }

    public function addAction()
    {
        $this->view->langs = Lang::find('active = 1');
        $this->tag->setTitle($this->t->_('add-translation'));
        if ($this->request->isPost()) {
            $pattern = $this->request->getPost('pattern', 'striptags');
            $pattern = str_replace([' ', '-'], '_', $pattern);
            $pattern = strtolower($pattern);
            $translates = $this->request->getPost('value', 'striptags');
            $translate = new Translate();
            $translate->setPattern($pattern);
            if (!$translate->save()) {
                $messages = $translate->getMessages();
                foreach ($messages as $message) {
                    $this->flash->error($this->t->_($message->getMessage()));
                }
                return true;
            }
            foreach ($translates as $id_lang => $translate_value) {
                $translate_lang = new TranslateLang();
                $translate_lang->setIdLang($id_lang);
                $translate_lang->setIdTranslate($translate->getId());
                $translate_lang->setValue(Tools::striptags($translate_value));
                if (!$translate_lang->save()) {
                    $messages = $translate_lang->getMessages();
                    foreach ($messages as $message) {
                        $this->flash->error($this->t->_($message->getMessage()));
                    }
                    return true;
                }
            }
            $this->flash->success($this->t->_('translate-successfully-added'));
            return $this->response->redirect($this->url->get(['for' => 'admin-translations-index']));
        }
    }
}
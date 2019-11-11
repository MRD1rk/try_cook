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
        $this->assets->collection('footerJs')->addJs('/admin-theme/js/translations.js');
        $translations = Translate::find(['order' => 'id DESC']);
        $langs = Lang::find('active = 1');
        $this->view->translations = $translations;
        $this->view->langs = $langs;
    }

    public function addAction()
    {
        $this->view->langs = Lang::find('active = 1');
        if ($this->request->isPost()) {
            $category = $this->request->getPost('category', 'striptags');
            $pattern = $this->request->getPost('pattern', 'striptags');
            $pattern = str_replace([' ', '-'], '_', $pattern);
            $pattern = strtolower($pattern);
            $translations = $this->request->getPost('value', 'striptags');
            $translation = new Translate();
            $translation->setPattern($pattern);
            $translation->setCategory($category);
            if (!$translation->save()) {
                $messages = $translation->getMessages();
                foreach ($messages as $message) {
                    $this->flash->error($this->t->_($message->getMessage()));
                }
                return true;
            }
            foreach ($translations as $id_lang => $translation_value) {
                $translation_lang = new TranslateLang();
                $translation_lang->setIdLang($id_lang);
                $translation_lang->setIdTranslation($translation->getId());
                $translation_lang->setValue(Tools::striptags($translation_value));
                if (!$translation_lang->save()) {
                    $messages = $translation_lang->getMessages();
                    foreach ($messages as $message) {
                        $this->flash->error($this->t->_($message->getMessage()));
                    }
                    return true;
                }
            }
            $this->flash->success($this->t->_('translation_successfully_added'));
            return $this->response->redirect($this->url->get(['for' => 'admin-translations-index']));
        }
    }

    public function updateAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $post = $this->request->getPost('data');
            $status = false;
            $message = null;
            if (!empty($post)) {
                foreach ($post as $item) {
                    $translationLang = new TranslateLang();
                    if (!$translationLang->save($item)) {
                        foreach ($translationLang->getMessages() as $errorMessage) {
                            $message[] = $this->t->_($errorMessage->getMessage());
                        }
                        $status = false;
                        continue;
                    } else {
                        $status = true;
                        $message = $this->t->_('translation_successfully_updated');
                        continue;
                    }

                }
                return $this->response->setJsonContent(['status' => $status, 'message' => Tools::arrToString($message)]);
            }
        }
    }

    public function deleteAction()
    {
        $id_translation = $this->dispatcher->getParam('id_translation');
        $translation = Translate::findFirst($id_translation);
        if (!$translation) {
            $this->flash->error($this->t->_('translation_not_found'));
            return $this->response->redirect($_SERVER['HTTP_REFERER']);
        }
        if ($translation->delete()) {
            $this->flash->success($this->t->_('successfully-deleted'));
            return $this->response->redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
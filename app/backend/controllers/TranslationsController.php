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
            $translations = $this->request->getPost('value', 'striptags');
            $translation = new Translate();
            $translation->setPattern($pattern);
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
            $this->flash->success($this->t->_('translation-successfully-added'));
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
//                    $translationLang = translationLang::findFirst('id_translation=' . $item['id_pattern'] . ' AND id_lang=' . $item['id_lang']);
                    $translationLang = new TranslateLang();
                    if (!$translationLang->save($item)) {
                        foreach ($translationLang->getMessages() as $errorMessage) {
                            $message[] = $this->t->_($errorMessage->getMessage());
                        }
                        $status = false;
                        continue;
                    } else {
                        $status = true;
                        $message = $this->t->_('translation-successfully-updated');
                        continue;
                    }

                }
                return json_encode(['status' => $status, 'message' => is_array($message) ? implode(', ', $message) : $message]);
            }
        }
    }

    public function parseAction()
    {
        $subject = file_get_contents('/var/www/try.cook/app/backend/controllers/TranslationsController.php');
        $currentTranslator = 't\._';//in view files
        $currentTranslator = '\$this->t->_'; // in php files
        $pattern = '/\b.*?'.$currentTranslator.'\(\'(.+?)\'\)/';
        $countMatches = preg_match_all(
            $pattern,
            $subject,
            $matches,
            PREG_SET_ORDER
        );
        $translationPatterns = [];
        if ($countMatches) {
            foreach ($matches as $match) {
                $translationPatterns[] = $match[1];
            }
        }
        return $translationPatterns;
    }
}
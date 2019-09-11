<?php


namespace Modules\Backend\Controllers;


use Models\Feature;
use Models\FeatureLang;

class FeaturesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $features = Feature::find();
        $this->view->features = $features;
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $feature_langs = $this->request->getPost('value');
            $feature = new Feature();
            $feature->save();
            if (!empty($feature_langs)) {
                foreach ($feature_langs as $id_lang => $value) {
                    $feature_value = new FeatureLang();
                    $feature_value->setIdFeature($feature->getId());
                    $feature_value->setIdLang($id_lang);
                    $feature_value->setValue($value);
                    if (!$feature_value->save()) {
                        foreach ($feature_value->getMessages() as $message) {
                            $this->flash->error($this->t->_($message));
                        }
                        return false;
                    }
                    $this->flash->success($this->t->_('feature_successfully_added'));
                    return $this->response->redirect($this->url->get(['for' => 'admin-features-update', 'id' => $feature->getId()]));
                }
            }

        }
    }
}
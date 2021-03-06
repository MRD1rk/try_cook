<?php


namespace Modules\Backend\Controllers;


use Helpers\Tools;
use Models\Feature;
use Models\FeatureLang;
use Models\FeatureValue;
use Models\FeatureValueLang;
use Phalcon\Mvc\View;

class FeaturesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->assets->collection('footerJs')->addJs('/vendor/jquery-tablednd/js/jquery.tablednd.min.js');
        $this->assets->collection('footerJs')->addJs('/admin-theme/js/features.js');
    }

    public function indexAction()
    {
        $features = Feature::find(['order' => 'position']);
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
                        return true;
                    }
                }
                $this->flash->success($this->t->_('feature_successfully_added'));
                return $this->response->redirect($this->url->get(['for' => 'admin-features-index', 'id' => $feature->getId()]));
            }

        }
    }

    public function addFeatureValueAction()
    {
        if ($this->request->isPost()) {
            $id_feature = $this->dispatcher->getParam('id_feature');
            $feature_value_langs = $this->request->getPost('value');
            $feature_value = new FeatureValue();
            $feature_value->setIdFeature($id_feature);
            $feature_value->save();
            if (!empty($feature_value_langs)) {
                foreach ($feature_value_langs as $id_lang => $value) {
                    $feature_value_lang = new FeatureValueLang();
                    $feature_value_lang->setIdFeatureValue($feature_value->getId());
                    $feature_value_lang->setIdLang($id_lang);
                    $feature_value_lang->setValue($value);
                    if (!$feature_value_lang->save()) {
                        foreach ($feature_value_lang->getMessages() as $message) {
                            $this->flash->error($this->t->_($message));
                        }
                        return true;
                    }
                }
                $this->flash->success($this->t->_('feature_value_successfully_added'));
                return $this->response->redirect($this->url->get(['for' => 'admin-features-view', 'id_feature' => $id_feature]));
            }

        }
    }

    public function deleteAction()
    {
        $id_feature = $this->dispatcher->getParam('id_feature');
        $feature = Feature::findFirst($id_feature);
        if ($feature->delete()) {
            $this->flash->success($this->t->_('feature_successfully_deleted'));
            return $this->response->redirect($this->url->get(['for' => 'admin-features-index']));
        }
    }

    public function viewAction()
    {
        $id_feature = $this->dispatcher->getParam('id_feature');
        $feature = Feature::findFirst($id_feature);
        $this->view->feature = $feature;
    }

    public function updateActiveAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_feature = $this->request->getPost('id_feature', 'int');
            $active = $this->request->getPost('active', 'int');
            $feature = Feature::findFirst($id_feature);
            $feature->setActive($active);
            if (!$feature->save()) {
                $status = false;
                foreach ($feature->getMessages() as $error) {
                    $message[] = $error->getMessage();
                }
            } else {
                $status = true;
                $message = $this->t->_('active_successfully_updated');
            }
            return json_encode([
                'status' => $status,
                'message' => Tools::arrToString($message)
            ]);
        }
    }

    public function updatePositionAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_feature = $this->request->getPost('id_feature', 'int');
            $position = $this->request->getPost('position', 'int');
            $feature = Feature::findFirst($id_feature);
            $feature->setPosition($position);
            if (!$feature->save()) {
                $status = false;
                foreach ($feature->getMessages() as $error) {
                    $message[] = $error->getMessage();
                }
            } else {
                $status = true;
                $message = $this->t->_('position_successfully_updated');
            }
            return json_encode([
                'status' => $status,
                'message' => Tools::arrToString($message)
            ]);
        }
    }

    public function updateValueActiveAction()
    {
        $this->view->disable();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_feature_value = $this->request->getPost('id_feature_value', 'int');
            $active = $this->request->getPost('active', 'int');
            $feature_value = FeatureValue::findFirst($id_feature_value);
            $feature_value->setActive($active);
            if (!$feature_value->save()) {
                $status = false;
                foreach ($feature_value->getMessages() as $error) {
                    $message[] = $error->getMessage();
                }
            } else {
                $status = true;
                $message = $this->t->_('active_successfully_updated');
            }
            return json_encode([
                'status' => $status,
                'message' => is_array($message) ? implode(', ', $message) : $message
            ]);
        }
    }

    public function updateValuePositionAction()
    {
        $this->view->disable();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_feature_value = $this->request->getPost('id_feature_value', 'int');
            $position = $this->request->getPost('position', 'int');
            $feature_value = FeatureValue::findFirst($id_feature_value);
            $feature_value->setPosition($position);
            if (!$feature_value->save()) {
                $status = false;
                foreach ($feature_value->getMessages() as $error) {
                    $message[] = $error->getMessage();
                }
            } else {
                $status = true;
                $message = $this->t->_('position_successfully_updated');
            }
            return json_encode([
                'status' => $status,
                'message' => is_array($message) ? implode(', ', $message) : $message
            ]);
        }
    }
}
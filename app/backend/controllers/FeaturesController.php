<?php


namespace Modules\Backend\Controllers;


use Models\Feature;
use Models\FeatureLang;
use Models\FeatureValue;

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
            $feature = new Feature(['order' => 'position']);
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
        $this->view->disable();
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
                $message = $this->t->_('active_successfully-updated');
            }
            return json_encode([
                'status' => $status,
                'message' => is_array($message) ? implode(', ', $message) : $message
            ]);
        }
    }

    public function updatePositionAction()
    {
        $this->view->disable();
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
                $message = $this->t->_('position_successfully-updated');
            }
            return json_encode([
                'status' => $status,
                'message' => is_array($message) ? implode(', ', $message) : $message
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
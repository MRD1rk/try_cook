<?php


namespace Modules\Backend\Controllers;


use Helpers\Tools;
use Models\Category;
use Models\CategoryFeature;
use Models\CategoryLang;
use Models\Feature;
use Phalcon\Mvc\View;

class CategoriesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->assets->collection('footerJs')->addJs('/vendor/jquery-tablednd/js/jquery.tablednd.min.js');
        $this->assets->collection('footerJs')->addJs('/admin-theme/js/categories.js');
        $categories = Category::find(['conditions' => 'id_parent=0', 'order' => 'position']);
        $this->view->categories = $categories;
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $category_langs = $this->request->getPost('title');
            $category = new Category();
            $category->save();
            if (!empty($category_langs)) {
                foreach ($category_langs as $id_lang => $value) {
                    $categoryLang = new CategoryLang();
                    $categoryLang->setIdCategory($category->getId());
                    $categoryLang->setIdLang($id_lang);
                    $categoryLang->setTitle($value);
                    if (!$categoryLang->save()) {
                        foreach ($categoryLang->getMessages() as $message) {
                            $this->flash->error($this->t->_($message->getMessage()));
                        }
                        return true;
                    }
                }
                $this->flash->success($this->t->_('category_successfully_added'));
                return $this->response->redirect($this->url->get(['for' => 'admin-categories-update', 'id_category' => $category->getId()]));
            }

        }
    }

    public function viewAction()
    {

    }

    public function deleteAction()
    {
        $id_category = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id_category);
        if ($category->delete()) {
            $this->flash->success($this->t->_('category_successfully_deleted'));
            return $this->response->redirect($this->url->get(['for' => 'admin-categories-index']));
        }
    }

    public function updatePositionAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_category = $this->request->getPost('id_category', 'int');
            $position = $this->request->getPost('position', 'int');
            $category = Category::findFirst($id_category);
            $category->setPosition($position);
            if (!$category->save()) {
                $status = false;
                foreach ($category->getMessages() as $error) {
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

    public function updateActiveAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_category = $this->request->getPost('id_category', 'int');
            $active = $this->request->getPost('active', 'int');
            $category = Category::findFirst($id_category);
            $category->setActive($active);
            if (!$category->save()) {
                $status = false;
                foreach ($category->getMessages() as $error) {
                    $message[] = $error->getMessage();
                }
            } else {
                $status = true;
                $message = $this->t->_('active_successfully_updated');
            }
            return $this->response->setJsonContent([
                'status' => $status,
                'message' => Tools::arrToString($message)
            ]);
        }
    }

    public function updateAction()
    {
        $id = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id);
        $this->view->category = $category;
        $errors = [];
        if ($this->request->isPost()) {
            $main = $this->request->getPost('main');
            $langs_post = $this->request->getPost('lang');
            if (!$category->save($main)) {
                foreach ($category->getMessages() as $message) {
                    $errors[] = $this->t->_($message->getMessage());
                }
            }
            if (!empty($errors)) {
                return $this->flash->error(Tools::arrToString($errors));
            }
            foreach ($langs_post as $id_lang => $lang_post) {
                $category_lang = new CategoryLang();
                $category_lang->setIdLang($id_lang);
                $category_lang->setIdCategory($category->getId());
                if (!$category_lang->save($lang_post)) {
                    foreach ($category_lang->getMessages() as $message) {
                        $errors[] = $this->t->_($message->getMessage());
                    }
                }
                if (!empty($errors)) {
                    return $this->flash->error((Tools::arrToString($errors)));
                }
            }
            $this->flash->success($this->t->_('successfully_updated'));
        }
    }

    public function updateImageAction()
    {
        $this->assets->collection('headerCss')->addCss('/admin-theme/css/categories.css');
        $id = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id);
        $this->view->category = $category;
        if ($this->request->isPost()) {
            $file = $this->request->getUploadedFiles()[0];
            if (!$category->uploadIcon($file)) {
                return $this->flash->error($this->t->_($category->getMessages()[0]->getMessage()));
            } else
                return $this->flash->success($this->t->_('successfully_saved'));
        }
    }

    public function updateFeaturesAction()
    {
        $this->assets->collection('footerJs')->addJs('/vendor/jquery-tablednd/js/jquery.tablednd.min.js');
        $this->assets->collection('footerJs')->addJs('admin-theme/js/library/sort-table.min.js');
        $this->assets->collection('footerJs')->addJs('admin-theme/js/features.js');
        $id_category = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id_category);
        $features = Feature::find();
        $category_features = $category->getCategoryFeatures() ?: new CategoryFeature();
        $category_features_assoc = Tools::assoc($category_features, 'id_feature');
        if ($this->request->isPost()) {
            $category_features->delete();
            $filters = $this->request->getPost('category_filters');
            foreach ($filters as $filter) {
                $category_feature = new CategoryFeature();
                $category_feature->setIdCategory($id_category);
                $category_feature->setIdFeature($filter['id_feature']);
                if (!$category_feature->save()) {
                    foreach ($category_feature->getMessages() as $message) {
                        $this->flash->error($message->getMessage());
                    }
                }
            }
            $this->flash->success($this->t->_('feature_successfully_updated'));
            return $this->response->redirect($this->url->get(['for'=>'admin-categories-update-feature', 'id_category' => $id_category]));
        }
        $this->view->category = $category;
        $this->view->category_features = $category_features_assoc;
        $this->view->features = $features;
    }

    public function updateFeaturePositionAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $message = null;
            $id_category = $this->request->getPost('id_category', 'int');
            $id_feature = $this->request->getPost('id_feature', 'int');
            $position = $this->request->getPost('position', 'int');
            $category_feature = CategoryFeature::findFirst('id_category=' . $id_category . ' AND id_feature=' . $id_feature);
            $category_feature->setPosition($position);
            if (!$category_feature->save()) {
                $status = false;
                foreach ($category_feature->getMessages() as $error) {
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
}
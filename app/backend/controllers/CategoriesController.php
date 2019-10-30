<?php


namespace Modules\Backend\Controllers;


use Models\Category;
use Models\CategoryLang;

class CategoriesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        
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
                            $this->flash->error($this->t->_($message));
                        }
                        return true;
                    }
                }
                $this->flash->success($this->t->_('category_successfully_added'));
                return $this->response->redirect($this->url->get(['for' => 'admin-categories-update', 'id_category' => $category->getId()]));
            }

        }
    }

    public function updateAction()
    {
        $id = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id);
        $this->view->category = $category;
    }

    public function updateImageAction()
    {
        $id = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id);
        $this->view->category = $category;
    }
}
<?php


namespace Modules\Frontend\Controllers;


use Models\Category;

class CategoriesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->container_class = 'container-lg';
        $this->assets->collection('headerCss')->addCss('css/categories.css');
    }

    public function indexAction()
    {
        
    }

    public function viewAction()
    {
        $id_category = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id_category);
        $this->view->category = $category;

    }
}
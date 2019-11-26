<?php

namespace Modules\Frontend\Controllers;

use Models\Category;
use Models\Feature;
use Models\Recipe;
use Models\Unit;

class RecipesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->container_class = 'container-lg';
        $this->assets->collection('headerCss')->addCss('css/recipes.css');
    }

    public function indexAction()
    {
        $categories = Category::find(['conditions' => 'active =1 AND id_parent=0']);
        $this->view->categories = $categories;
    }

    public function addAction()
    {
        $this->tag->setTitle($this->t->_('add-recipe'));
        $this->assets->collection('headerCss')->addCss('vendor/selectize/css/selectize.css');
        $this->assets->collection('footerJs')->addJs('vendor/selectize/js/standalone/selectize.min.js');
        $this->assets->collection('footerJs')->addJs('vendor/tinymce/tinymce.min.js');
        $this->assets->collection('footerJs')->addJs('js/recipes.js');
        $units = Unit::find();
        $units_data = [];
        foreach ($units as $unit) {
            $units_data[$unit->getId()] = $unit->lang->getTitle();
        }
        $categories = Category::find('id_parent = 0');
        $features = Feature::getFeatures();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $data = $this->request->getPost();
        }

        $this->view->units = json_encode($units_data);
        $this->view->features = $features;
        $this->view->categories = $categories;
    }

    public function uploadImageAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $post = $this->request->getPost();
            echo '<pre>';
            var_dump('2');
            die();

        }
    }

    public function viewAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }
}
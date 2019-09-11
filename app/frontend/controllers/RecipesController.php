<?php

namespace Modules\Frontend\Controllers;

use Models\Category;
use Models\Feature;
use Models\Recipe;

class RecipesController extends BaseController
{
    public function indexAction()
    {
    }

    public function addAction()
    {
        $this->tag->setTitle($this->t->_('add-recipe'));
        $this->assets->collection('headerCss')->addCss('vendor/selectize/css/selectize.css');
        $this->assets->collection('headerCss')->addCss('css/recipes.css');
        $this->assets->collection('footerJs')->addJs('vendor/selectize/js/standalone/selectize.min.js');
        $this->assets->collection('footerJs')->addJs('js/recipes.js');
        $categories = Category::find('id_parent = 0');
        $features = Feature::find('id=1');
        if ($this->request->isPost() && $this->request->isAjax()) {
            $data = $this->request->getPost();
            echo '<pre>';
            var_dump($data);
            die();
        }
        $this->view->features = $features;
        $this->view->categories = $categories;
    }
    public function viewAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }
}
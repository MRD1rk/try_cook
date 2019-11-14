<?php


namespace Modules\Backend\Controllers;


use Models\Feature;
use Models\Recipe;

class RecipesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $recipes = Recipe::find();
        $this->view->recipes = $recipes;
    }

    public function updateAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }

    public function updateFeatureAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe');
        $recipe = Recipe::findFirst($id_recipe);
        $features = Feature::find();
        $this->view->recipe = $recipe;
        $this->view->features = $features;
    }
}
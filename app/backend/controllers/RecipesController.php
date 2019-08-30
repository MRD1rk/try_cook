<?php


namespace Modules\Backend\Controllers;


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

    public function addAction()
    {

    }
}
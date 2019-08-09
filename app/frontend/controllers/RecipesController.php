<?php


namespace Modules\Frontend\Controllers;


use Models\Recipe;

class RecipesController extends BaseController
{
    public function indexAction()
    {

    }

    public function viewAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }
}
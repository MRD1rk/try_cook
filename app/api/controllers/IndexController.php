<?php

namespace Modules\Api\Controllers;


use Models\Ingredient;

class IndexController extends BaseController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        
    }
    public function getIngredientsAction()
    {
//        if ($this->request->isPost() && $this->request->isAjax()) {
            $query = $this->request->getPost('query', 'string');
            $query = 'рис';
            $ingredients = Ingredient::getIngredient(['name' => $query]);
            $result = $ingredients[0];
            echo '<pre>';
            var_dump($result);
            die();
//        }
    }

    public function getRecipePartAction()
    {

    }
}


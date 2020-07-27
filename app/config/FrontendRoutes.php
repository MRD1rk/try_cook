<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

class FrontendRoutes extends RouterGroup
{
    public function __construct($config = null)
    {
        parent::__construct($config);
        $this->init();
    }

    public function init()
    {
        $this->setPaths(
            [
                "module" => "frontend",
            ]
        );

        $this->add('/:controller', array(
            'controller' => 1,
            'action' => 'index'
        ));
        $this->add('/:controller/:action', array(
            'controller' => 1,
            'action' => 2
        ));
        $this->add('/([a-z]{2})', array(
            'controller' => 'index',
            'action' => 'index',
            'iso_code' => 1
        ))->setName('index-index');
        $this->add('/([a-z]{2})/get-translations', array(
            'controller' => 'index',
            'action' => 'getTranslations',
            'iso_code' => 1
        ));
        $this->add('/([a-z]{2})/recipes', array(
            'controller' => 'recipes',
            'action' => 'index',
            'iso_code' => 1,
        ))->setName('recipes-index');
        $this->add('/([a-z]{2})/recipes/add/:int', array(
            'controller' => 'recipes',
            'action' => 'add',
            'iso_code' => 1,
            'id_recipe' => 2
        ))->setName('recipes-add');
        $this->add('/([a-z]{2})/recipes/add', array(
            'controller' => 'recipes',
            'action' => 'add',
            'iso_code' => 1
        ))->setName('recipes-add');
        $this->add('/([a-z]{2})/recipes/new', array(
            'controller' => 'recipes',
            'action' => 'new',
            'iso_code' => 1
        ))->setName('recipes-new');
        $this->add('/([a-z]{2})/recipes/add/:int/upload-image', [
            'controller' => 'recipes',
            'action' => 'uploadImage',
            'iso_code' => 1,
            'id_recipe' => 2
        ])->setName('recipes-upload-image');
        $this->add('/([a-z]{2})/recipes/add/:int/upload-step-image', [
            'controller' => 'recipes',
            'action' => 'uploadStepImage',
            'iso_code' => 1,
            'id_recipe' => 2
        ])->setName('recipes-upload-step-image');
        $this->add('/([a-z]{2}/recipes/add/:int/add-recipe-step)', [
            'controller' => 'recipes',
            'action' => 'addRecipeStep',
            'iso_code' => 1,
            'id_recipe' => 2,
        ])->setName('recipes-add-step');
        $this->add('/([a-z]{2}/recipes/add/:int/delete-step/:int)', [
            'controller' => 'recipes',
            'action' => 'deleteRecipeStep',
            'iso_code' => 1,
            'id_recipe' => 2,
            'id_step' => 3
        ])->setName('recipes-delete-step');
        $this->add('/([a-z]{2}/recipes/add/:int/add-recipe-ingredient)', [
            'controller' => 'recipes',
            'action' => 'addRecipeIngredient',
            'iso_code' => 1,
            'id_recipe' => 2,
        ])->setName('recipes-add-recipe-ingredient');
        $this->add('/([a-z]{2}/recipes/add/:int/delete-recipe-ingredient/:int)', [
            'controller' => 'recipes',
            'action' => 'deleteRecipeIngredient',
            'iso_code' => 1,
            'id_recipe' => 2,
            'id_recipe_ingredient' => 3,
        ])->setName('recipes-delete-recipe-ingredient');
        $this->add('/([a-z]{2}/recipes/add/:int/update-recipe-ingredient/:int)', [
            'controller' => 'recipes',
            'action' => 'updateRecipeIngredient',
            'iso_code' => 1,
            'id_recipe' => 2,
            'id_recipe_ingredient' => 3,
        ])->setName('recipes-delete-recipe-ingredient');
        $this->add('/([a-z]{2}/recipes/add/:int/update-recipe-ingredient-position/:int)', [
            'controller' => 'recipes',
            'action' => 'updateRecipeIngredientPosition',
            'iso_code' => 1,
            'id_recipe' => 2,
            'id_recipe_ingredient' => 3,
        ])->setName('recipes-delete-recipe-ingredient');
        $this->add('/([a-z]{2}/recipes/add/:int/add-recipe-part)', [
            'controller' => 'recipes',
            'action' => 'addRecipePart',
            'iso_code' => 1,
            'id_recipe' => 2,
        ])->setName('recipes-add-part');
        $this->add('/([a-z]{2}/recipes/add/:int/update-recipe-part)', [
            'controller' => 'recipes',
            'action' => 'updateRecipePart',
            'iso_code' => 1,
            'id_recipe' => 2,
        ])->setName('recipes-update-part');
        $this->add('/([a-z]{2}/recipes/add/:int/delete-part/:int)', [
            'controller' => 'recipes',
            'action' => 'deleteRecipePart',
            'iso_code' => 1,
            'id_recipe' => 2,
            'id_recipe_part' => 3
        ])->setName('recipes-delete-part');
        $this->add('/([a-z]{2})/categories/filter', array(
            'controller' => 'categories',
            'action' => 'filter',
            'iso_code' => 1,
        ))->setName('categories-filter');
        $this->add('/([a-z]{2})/recipes/([0-9]+)[-]([a-zA-Z0-9\_\-]+)[.]html', array(
            'controller' => 'recipes',
            'action' => 'view',
            'iso_code' => 1,
            'id_recipe' => 2,
            'link_rewrite' => 3
        ))->setName('recipes-view');
        $this->add('/([a-z]{2})/([0-9]+)[-]([a-zA-Z0-9\_\-]+)', [
            'controller' => 'categories',
            'action' => 'view',
            'iso_code' => 1,
            'id_category' => 2,
            'link_rewrite' => 3
        ])->setName('categories-view');

        $this->add('/([a-z]{2})/auth/signup', [
            'controller' => 'auth',
            'action' => 'signup',
            'iso_code' => 1
        ])->setName('auth-signup');
        $this->add('/([a-z]{2})/auth/signin', [
            'controller' => 'auth',
            'action' => 'signin',
            'iso_code' => 1
        ])->setName('auth-signin');
        $this->add('/([a-z]{2})/auth/logout', [
            'controller' => 'auth',
            'action' => 'logout',
            'iso_code' => 1
        ])->setName('auth-logout');
    }
}
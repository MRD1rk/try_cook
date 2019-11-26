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

        $this->add('/([a-z]{2})', array(
            'controller' => 'index',
            'action' => 'index',
            'iso_code' => 1
        ))->setName('index-index');
        $this->add('/([a-z]{2})/signup', array(
            'controller' => 'index',
            'action' => 'signup',
            'iso_code' => 1
        ));
        $this->add('/([a-z]{2})/signin', array(
            'controller' => 'index',
            'action' => 'signin',
            'iso_code' => 1
        ));
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
        $this->add('/([a-z]{2})/recipes/add', array(
            'controller' => 'recipes',
            'action' => 'add',
            'iso_code' => 1,
        ))->setName('recipes-add');
        $this->add('/recipes/upload-image', [
            'controller' => 'recipes',
            'action' => 'uploadImage'
        ])->setName('recipes-upload-image');
        $this->add('/recipes/upload-steps-image', [
            'controller' => 'recipes',
            'action' => 'uploadStepsImage'
        ])->setName('recipes-upload-steps-image');
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

    }
}
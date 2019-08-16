<?php

use Phalcon\Mvc\Router\Group as RouterGroup;
use Models\Configuration;

class BackendRoutes extends RouterGroup
{
    protected static $prefix;

    public function __construct($config = null)
    {
        self::$prefix = '/' . Configuration::get('ADMIN_PREFIX');
        parent::__construct($config);
        $this->init();
    }

    public function init()
    {
        $this->setPaths(
            [
                'module' => 'backend'
            ]
        );
        $this->add(self::$prefix, [
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index'
        ])->setName('admin-index-index');
        $this->setPrefix(self::$prefix);
        $this->add('/:controller', [
            'controller' => 1,
            'action' => 'index'
        ]);
        $this->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2
        ]);
        $this->add('/login', [
            'controller' => 'index',
            'action' => 'login'
        ]);
        $this->add('/recipes', [
            'controller' => 'recipes',
            'action' => 'index'
        ])->setName('admin-recipes-index');
        $this->add('/recipes/add', [
            'controller' => 'recipes',
            'action' => 'add'
        ])->setName('admin-recipes-add');
    }


}
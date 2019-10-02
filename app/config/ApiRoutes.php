<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

class ApiRoutes extends RouterGroup
{
    protected static $prefix;

    public function __construct($config = null)
    {
        self::$prefix = '/api';
        parent::__construct($config);
        $this->init();
    }

    public function init()
    {
        $this->setPaths(
            [
                "module" => "api",
            ]
        );
        $this->add(self::$prefix, [
            'module' => 'api',
            'controller' => 'index',
            'action' => 'index'
        ])->setName('api-index-index');
        $this->setPrefix(self::$prefix);
        $this->add('/:controller', [
            'controller' => 1,
            'action' => 'index'
        ]);
        $this->add('/get-ingredients', [
            'controller' => 'index',
            'action' => 'getIngredients'
        ]);
        $this->add('/get-units', [
            'controller' => 'index',
            'action' => 'getUnits'
        ]);
    }
}
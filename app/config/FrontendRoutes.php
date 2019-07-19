<?php

use Phalcon\Mvc\Router\Group as RouterGroup;
use Phalcon\Mvc\Router;

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
                'module' => 'frontend'
            ]
        );

        $this->add('/:controller', [
            'controller' => 1,
            'action' => 'index'
        ]);
    }
}
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
        ));
        $this->add('/([a-z]{2})/signup', array(
            'controller' => 'index',
            'action' => 'signup',
            'iso_code' => 1
        ));
    }
}
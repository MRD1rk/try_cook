<?php

namespace Models;

class BaseModel extends \Phalcon\Mvc\Model
{
    public static function findFirst($params = null)
    {
        return !$params ? false : parent::findFirst($params);
    }

    public function __isset($property)
    {
        $prefix = 'get';
        $method = $prefix . ucfirst($property);
        return isset($method);
    }
}
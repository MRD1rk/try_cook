<?php

namespace Models;

class BaseModel extends \Phalcon\Mvc\Model
{
    public static function findFirst($params = null)
    {
        return !$params ? false : parent::findFirst($params);
    }
}
<?php

namespace Models;

use Phalcon\Di;
use Phalcon\Mvc\Model\ResultsetInterface;

class Configuration extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $value;

    /**
     *
     * @var string
     */
    public $date_add;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_configurations');
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Configuration[]|Configuration|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Configuration|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'value' => 'value',
            'date_add' => 'date_add'
        ];
    }

    /**
     * @param string $name
     * @param bool $useTranslation
     * @return string|null
     */
    public static function get(string $name, bool $useTranslation = false)
    {
        $configuration = self::findFirstByName($name);
        if (!$configuration)
            return null;
        return !$useTranslation ? $configuration->value : Di::getDefault()->get('t')->_($configuration->value);

    }
}

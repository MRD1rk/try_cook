<?php

namespace Models;

class Lang extends \Phalcon\Mvc\Model
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
    public $iso_code;

    /**
     *
     * @var string
     */
    public $lang_code;

    /**
     *
     * @var string
     */
    public $date_format_lite;

    /**
     *
     * @var string
     */
    public $date_format_full;

    /**
     *
     * @var integer
     */
    public $active;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_langs';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Lang[]|Lang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Lang|\Phalcon\Mvc\Model\ResultInterface
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
            'iso_code' => 'iso_code',
            'lang_code' => 'lang_code',
            'date_format_lite' => 'date_format_lite',
            'date_format_full' => 'date_format_full',
            'active' => 'active'
        ];
    }

}

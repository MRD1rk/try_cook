<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class PartLang extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id_part;

    /**
     *
     * @var integer
     */
    protected $id_lang;

    /**
     *
     * @var string
     */
    protected $value;

    /**
     * Method to set the value of field id_part
     *
     * @param integer $id_part
     * @return $this
     */
    public function setIdPart($id_part)
    {
        $this->id_part = $id_part;

        return $this;
    }

    /**
     * Method to set the value of field id_lang
     *
     * @param integer $id_lang
     * @return $this
     */
    public function setIdLang($id_lang)
    {
        $this->id_lang = $id_lang;

        return $this;
    }

    /**
     * Method to set the value of field value
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Returns the value of field id_part
     *
     * @return integer
     */
    public function getIdPart()
    {
        return $this->id_part;
    }

    /**
     * Returns the value of field id_lang
     *
     * @return integer
     */
    public function getIdLang()
    {
        return $this->id_lang;
    }

    /**
     * Returns the value of field value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_part_lang');
        $this->belongsTo('id_lang', 'Models\Lang', 'id', ['alias' => 'lang']);
        $this->belongsTo('id_part', 'Models\Part', 'id', ['alias' => 'part']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PartLang[]|PartLang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PartLang|\Phalcon\Mvc\Model\ResultInterface
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
            'id_part' => 'id_part',
            'id_lang' => 'id_lang',
            'value' => 'value'
        ];
    }

}

<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class FeatureValueLang extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id_feature_value;

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
     * Method to set the value of field id_feature_value
     *
     * @param integer $id_feature_value
     * @return $this
     */
    public function setIdFeatureValue($id_feature_value)
    {
        $this->id_feature_value = $id_feature_value;

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
     * Returns the value of field id_feature_value
     *
     * @return integer
     */
    public function getIdFeatureValue()
    {
        return $this->id_feature_value;
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
        $this->setSource('tc_feature_value_lang');
        $this->belongsTo('id_feature_value', 'Models\FeatureValue', 'id', ['alias' => 'FeatureValue']);
        $this->belongsTo('id_lang', 'Models\Lang', 'id', ['alias' => 'lang']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return FeatureValueLang[]|FeatureValueLang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null) :ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return FeatureValueLang|\Phalcon\Mvc\Model\ResultInterface
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
            'id_feature_value' => 'id_feature_value',
            'id_lang' => 'id_lang',
            'value' => 'value'
        ];
    }

}

<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class Lang extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $iso_code;

    /**
     *
     * @var string
     */
    protected $lang_code;

    /**
     *
     * @var string
     */
    protected $date_format_lite;

    /**
     *
     * @var string
     */
    protected $date_format_full;

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field iso_code
     *
     * @param string $iso_code
     * @return $this
     */
    public function setIsoCode($iso_code)
    {
        $this->iso_code = $iso_code;

        return $this;
    }

    /**
     * Method to set the value of field lang_code
     *
     * @param string $lang_code
     * @return $this
     */
    public function setLangCode($lang_code)
    {
        $this->lang_code = $lang_code;

        return $this;
    }

    /**
     * Method to set the value of field date_format_lite
     *
     * @param string $date_format_lite
     * @return $this
     */
    public function setDateFormatLite($date_format_lite)
    {
        $this->date_format_lite = $date_format_lite;

        return $this;
    }

    /**
     * Method to set the value of field date_format_full
     *
     * @param string $date_format_full
     * @return $this
     */
    public function setDateFormatFull($date_format_full)
    {
        $this->date_format_full = $date_format_full;

        return $this;
    }

    /**
     * Method to set the value of field active
     *
     * @param integer $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field iso_code
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->iso_code;
    }

    /**
     * Returns the value of field lang_code
     *
     * @return string
     */
    public function getLangCode()
    {
        return $this->lang_code;
    }

    /**
     * Returns the value of field date_format_lite
     *
     * @return string
     */
    public function getDateFormatLite()
    {
        return $this->date_format_lite;
    }

    /**
     * Returns the value of field date_format_full
     *
     * @return string
     */
    public function getDateFormatFull()
    {
        return $this->date_format_full;
    }

    /**
     * Returns the value of field active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_langs');
        $this->hasMany('id', 'Models\CategoryLang', 'id_lang', ['alias' => 'TcCategoryLang']);
        $this->hasMany('id', 'Models\CookMethodLang', 'id_lang', ['alias' => 'TcCookMethodLang']);
        $this->hasMany('id', 'Models\FeatureLang', 'id_lang', ['alias' => 'TcFeatureLang']);
        $this->hasMany('id', 'Models\FeatureValueLang', 'id_lang', ['alias' => 'TcFeatureValueLang']);
        $this->hasMany('id', 'Models\RecipeLang', 'id_lang', ['alias' => 'TcRecipeLang']);
        $this->hasMany('id', 'Models\RecipePartLang', 'id_lang', ['alias' => 'TcRecipePartLang']);
        $this->hasMany('id', 'Models\RecipeStepLang', 'id_lang', ['alias' => 'TcRecipeStepLang']);
        $this->hasMany('id', 'Models\TranslateLang', 'id_lang', ['alias' => 'TcTranslateLang']);
        $this->hasMany('id', 'Models\UnitLang', 'id_lang', ['alias' => 'TcUnitLang']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Lang[]|Lang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
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

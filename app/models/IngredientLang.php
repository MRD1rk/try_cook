<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class IngredientLang extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id_ingredient;

    /**
     *
     * @var integer
     */
    protected $id_lang;

    /**
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     * Method to set the value of field id_ingredient
     *
     * @param integer $id_ingredient
     * @return $this
     */
    public function setIdIngredient($id_ingredient)
    {
        $this->id_ingredient = $id_ingredient;

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
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = mb_strtoupper(mb_substr($title, 0, 1)) . mb_substr($title, 1);;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns the value of field id_ingredient
     *
     * @return integer
     */
    public function getIdIngredient()
    {
        return $this->id_ingredient;
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
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_ingredient_lang');
        $this->belongsTo('id_ingredient', 'Models\Ingredient', 'id', ['alias' => 'ingredient']);
        $this->belongsTo('id_lang', 'Models\Lang', 'id', ['alias' => 'lang']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return IngredientLang[]|IngredientLang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null):ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return IngredientLang|\Phalcon\Mvc\Model\ResultInterface
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
            'id_ingredient' => 'id_ingredient',
            'id_lang' => 'id_lang',
            'title' => 'title',
            'description' => 'description'
        ];
    }

}

<?php

namespace Models;

class Recipe extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $default_person_count;

    /**
     *
     * @var integer
     */
    protected $cooking_time;

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     *
     * @var string
     */
    protected $date_add;

    /**
     *
     * @var string
     */
    protected $date_upd;

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
     * Method to set the value of field default_person_count
     *
     * @param integer $default_person_count
     * @return $this
     */
    public function setDefaultPersonCount($default_person_count)
    {
        $this->default_person_count = $default_person_count;

        return $this;
    }

    /**
     * Method to set the value of field cooking_time
     *
     * @param integer $cooking_time
     * @return $this
     */
    public function setCookingTime($cooking_time)
    {
        $this->cooking_time = $cooking_time;

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
     * Method to set the value of field date_add
     *
     * @param string $date_add
     * @return $this
     */
    public function setDateAdd($date_add)
    {
        $this->date_add = $date_add;

        return $this;
    }

    /**
     * Method to set the value of field date_upd
     *
     * @param string $date_upd
     * @return $this
     */
    public function setDateUpd($date_upd)
    {
        $this->date_upd = $date_upd;

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
     * Returns the value of field default_person_count
     *
     * @return integer
     */
    public function getDefaultPersonCount()
    {
        return $this->default_person_count;
    }

    /**
     * Returns the value of field cooking_time
     *
     * @return integer
     */
    public function getCookingTime()
    {
        return $this->cooking_time;
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
     * Returns the value of field date_add
     *
     * @return string
     */
    public function getDateAdd()
    {
        return $this->date_add;
    }

    /**
     * Returns the value of field date_upd
     *
     * @return string
     */
    public function getDateUpd()
    {
        return $this->date_upd;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Models\CategoryRecipe', 'id_recipe', ['alias' => 'categoryRecipe']);
        $this->hasMany('id', 'Models\RecipeIngredient', 'id_recipe', ['alias' => 'recipeIngredient']);
        $this->hasMany('id', 'Models\RecipeLang', 'id_recipe', ['alias' => 'lang']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_recipes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Recipe[]|Recipe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Recipe|\Phalcon\Mvc\Model\ResultInterface
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
            'default_person_count' => 'default_person_count',
            'cooking_time' => 'cooking_time',
            'active' => 'active',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }

}

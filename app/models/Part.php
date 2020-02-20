<?php

namespace Models;

use Phalcon\Di;
use Phalcon\Mvc\Model\Query;

class Part extends BaseModel
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
    protected $active;

    /**
     *
     * @var string
     */
    protected $date_add;

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
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Models\PartLang', 'id_part', ['alias' => 'langs']);
        $this->hasMany('id', 'Models\RecipeIngredient', 'id_recipe_part', ['alias' => 'ingredients']);
        $this->hasMany('id', 'Models\RecipePart', 'id_part', ['alias' => 'recipe_parts']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_parts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Part[]|Part|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Part|\Phalcon\Mvc\Model\ResultInterface
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
            'active' => 'active',
            'date_add' => 'date_add'
        ];
    }

    /**
     * @param int $active
     * @return mixed
     */
    public static function getParts($active = 1)
    {
        $id_lang = Context::getInstance()->getLang()->getId();
        $phql = 'SELECT p.id, pl.value as title FROM Models\Part p 
        LEFT JOIN Models\PartLang pl ON (p.id = pl.id_part)
        WHERE p.active = ' . (int)$active . ' AND pl.id_lang=' . (int)$id_lang;
        $query = new Query($phql, Di::getDefault());
        $rows = $query->execute();
        if (!$rows->count())
            return null;
        return $rows;
    }

}

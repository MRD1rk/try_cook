<?php

namespace Models;

class RecipePart extends BaseModel
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
    protected $id_recipe;

    /**
     *
     * @var integer
     */
    protected $id_part;

    /**
     *
     * @var integer
     */
    protected $position;

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
     * Method to set the value of field id_recipe
     *
     * @param integer $id_recipe
     * @return $this
     */
    public function setIdRecipe($id_recipe)
    {
        $this->id_recipe = $id_recipe;

        return $this;
    }

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
     * Method to set the value of field position
     *
     * @param integer $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

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
     * Returns the value of field id_recipe
     *
     * @return integer
     */
    public function getIdRecipe()
    {
        return $this->id_recipe;
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
     * Returns the value of field position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_part', 'Models\Part', 'id', ['alias' => 'part']);
        $this->belongsTo('id_recipe', 'Models\Recipe', 'id', ['alias' => 'recipe']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_recipe_part';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipePart[]|RecipePart|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipePart|\Phalcon\Mvc\Model\ResultInterface
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
            'id_recipe' => 'id_recipe',
            'id_part' => 'id_part',
            'position' => 'position'
        ];
    }

}

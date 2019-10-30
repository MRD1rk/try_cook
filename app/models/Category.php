<?php

namespace Models;

class Category extends BaseModel
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
    protected $id_parent;

    /**
     *
     * @var integer
     */
    protected $position;

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     *
     * @var integer
     */
    protected $level_depth;

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
     * Method to set the value of field id_parent
     *
     * @param integer $id_parent
     * @return $this
     */
    public function setIdParent($id_parent)
    {
        $this->id_parent = $id_parent;

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
     * Method to set the value of field active
     *
     * @param integer $level_depth
     * @return $this
     */
    public function setLevelDepth($level_depth)
    {
        $this->level_depth = $level_depth;

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
     * Returns the value of field id_parent
     *
     * @return integer
     */
    public function getIdParent()
    {
        return $this->id_parent;
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
     * Returns the value of field active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Returns the value of field level_depth
     *
     * @return integer
     */
    public function getLevelDepth()
    {
        return $this->level_depth;
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
        $this->hasOne('id', 'Models\CategoryLang', 'id_category', [
            'alias' => 'lang',
        ]);
        $this->hasMany('id', 'Models\CategoryRecipe', 'id_category', ['alias' => 'categoryRecipes']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_categories';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]|Category|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category|\Phalcon\Mvc\Model\ResultInterface
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
            'id_parent' => 'id_parent',
            'position' => 'position',
            'active' => 'active',
            'level_depth' => 'level_depth',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }

}

<?php

namespace Models;

use Phalcon\Mvc\Model\Query;

class Unit extends BaseModel
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
//        $this->hasMany('id', 'Models\RecipeIngredient', 'id_unit', ['alias' => 'recip']);
        $this->hasMany('id', 'Models\UnitLang', 'id_unit', ['alias' => 'langs']);
        $this->hasOne('id', 'Models\UnitLang', 'id_unit', ['alias' => 'lang',
            'params' => [
                'id_lang=' . Context::getInstance()->getLang()->id
            ]]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_units';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Unit[]|Unit|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Unit|\Phalcon\Mvc\Model\ResultInterface
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

    public static function getUnits($ids = [])
    {
        if (empty($ids))
            return null;
        $id_lang = Context::getInstance()->getLang()->id;
        $phql = 'SELECT u.id,ul.title FROM Models\Unit u LEFT JOIN Models\UnitLang ul ON ul.id_unit=u.id AND ul.id_lang=' . $id_lang .
            ' WHERE u.id IN (' . implode(', ', $ids) . ')';
        $model = new self;
        $query = new Query($phql, $model->getDI());
        $results = $query->execute();
        if (!$results->count())
            return null;
        return $results;

    }

}

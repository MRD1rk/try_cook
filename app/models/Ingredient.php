<?php

namespace Models;

use Models\Context;
use Phalcon\Mvc\Model\Query;

class Ingredient extends BaseModel
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
    protected $unit_available = [];

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     *
     * @var integer
     */
    protected $old_id;

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
     * Method to set the value of field unit_available
     *
     * @param string $unit_available
     * @return $this
     */
    public function setUnitAvailable($unit_available)
    {
        $this->unit_available = $unit_available;

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
     * Method to set the value of field old_id
     *
     * @param integer $old_id
     * @return $this
     */
    public function setOldId($old_id)
    {
        $this->old_id = $old_id;

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
     * Returns the value of field unit_available
     *
     * @return array
     */
    public function getUnitAvailable()
    {
        return unserialize($this->unit_available);
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
     * Returns the value of field old_id
     *
     * @return integer
     */
    public function getOldId()
    {
        return $this->old_id;
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
        $this->hasMany('id', 'Models\IngredientLang', 'id_ingredient', ['alias' => 'langs']);
        $this->hasOne('id', 'Models\IngredientLang', 'id_ingredient', ['alias' => 'lang', 'params' =>
            [
                'id_lang' => Context::getInstance()->getLang()->getId()
            ]]);
        $this->hasMany('id', 'Models\RecipeIngredient', 'id_ingredient', ['alias' => 'recipeIngredients']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_ingredients';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ingredient[]|Ingredient|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ingredient|\Phalcon\Mvc\Model\ResultInterface
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
            'unit_available' => 'unit_available',
            'active' => 'active',
            'old_id' => 'old_id',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }


    public static function getIngredient($params = [])
    {
        $where_conditions = [];
        $id_lang = Context::getInstance()->getLang()->id;
        if (isset($params['ids'])) {
            $where_conditions[] = 'id_ingredient IN (' . implode(',', $params['ids']) . ')';
        }
        $phql = 'SELECT il.*,i.* FROM Models\Ingredient i LEFT JOIN Models\IngredientLang il ON il.id_ingredient = i.id AND il.id_lang=' . $id_lang . ' 
        WHERE ' . implode(' AND ', $where_conditions);
        $model = new self;
        $query = new Query($phql, $model->getDI());
        $results = $query->execute();
        if (!$results->count())
            return null;
        return $results;
    }

    public function getUnits()
    {
        return Unit::find('id IN(' . implode(',', $this->getUnitAvailable()) . ')');
    }
}

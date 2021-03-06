<?php

namespace Models;

use Phalcon\Di;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Validation;

class RecipeIngredient extends BaseModel
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
    protected $id_recipe_part;

    /**
     *
     * @var integer
     */
    protected $id_ingredient;

    /**
     *
     * @var integer
     */
    protected $id_unit;

    /**
     *
     * @var integer
     */
    protected $count;

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
     * Method to set the value of field id_recipe_part
     *
     * @param integer $id_recipe_part
     * @return $this
     */
    public function setIdRecipePart($id_recipe_part)
    {
        $this->id_recipe_part = $id_recipe_part;

        return $this;
    }

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
     * Method to set the value of field id_unit
     *
     * @param integer $id_unit
     * @return $this
     */
    public function setIdUnit($id_unit)
    {
        $this->id_unit = $id_unit;

        return $this;
    }

    /**
     * Method to set the value of field count
     *
     * @param integer $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

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
     * Returns the value of field id_recipe_part
     *
     * @return integer
     */
    public function getIdRecipePart()
    {
        return $this->id_recipe_part;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            ['id_recipe','id_recipe_part','id_ingredient'],
            new Validation\Validator\Uniqueness(
                [
                    'model' => $this,
                    'message' => 'ingredient_must_be_unique',
                ]
            )
        );

        return $this->validate($validator);
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
     * Returns the value of field id_unit
     *
     * @return integer
     */
    public function getIdUnit()
    {
        return $this->id_unit;
    }

    /**
     * Returns the value of field count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
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
        $this->setSource('tc_recipe_ingredient');
        $this->keepSnapshots(true);
        $this->belongsTo('id_ingredient', 'Models\Ingredient', 'id', ['alias' => 'ingredient']);
        $this->belongsTo('id_recipe_part', 'Models\Part', 'id', ['alias' => 'part']);
        $this->belongsTo('id_recipe', 'Models\Recipe', 'id', ['alias' => 'recipe']);
        $this->belongsTo('id_unit', 'Models\Unit', 'id', ['alias' => 'unit']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeIngredient[]|RecipeIngredient|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null):ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeIngredient|\Phalcon\Mvc\Model\ResultInterface
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
            'id_recipe_part' => 'id_recipe_part',
            'id_ingredient' => 'id_ingredient',
            'id_unit' => 'id_unit',
            'count' => 'count',
            'position' => 'position'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->position = $this->count('id_recipe=' . $this->getIdRecipe() . ' AND id_recipe_part='.$this->getIdRecipePart()) + 1;
    }

    public function afterDelete()
    {
        $db = Di::getDefault()->get('db');
        $sql = 'UPDATE tc_recipe_ingredient SET `position` = (`position` - 1) 
                WHERE `position` > ' . $this->getPosition() . ' AND id_recipe=' . $this->getIdRecipe() .
                ' AND id_recipe_part = '. $this->getIdRecipePart();
        $db->execute($sql);
    }
    public function beforeSave()
    {
        if ($this->hasSnapshotData()) {
            if ($this->hasChanged('position')) {
                $old_position = $this->getSnapshotData()['position'];
                $new_position = $this->getPosition();
                if ($old_position > $new_position) {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position + 1
                WHERE position >=' . $new_position . ' 
                AND position < ' . $old_position . ' 
                AND id != ' . $this->getId(). ' 
                AND id_recipe_part='.$this->getIdRecipePart();
                } else {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position - 1
                WHERE position <=' . $new_position . ' 
                AND position > ' . $old_position . ' 
                AND id != ' . $this->getId(). ' 
                AND id_recipe_part='.$this->getIdRecipePart();
                }
                if (!$result = $this->getWriteConnection()->query($phql)) {
                    $message = new Message('sql query error (position). Result: ' . var_dump($result));
                    $this->appendMessage($message);
                    return false;
                }
            }
            return true;
        }
    }
}

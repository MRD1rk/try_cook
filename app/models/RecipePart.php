<?php

namespace Models;

use Phalcon\Di;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\ResultsetInterface;

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
        $this->keepSnapshots(true);
        $this->setSource('tc_recipe_part');
        $this->hasMany('id', RecipeIngredient::class, 'id_recipe_part', ['alias' => 'ingredients',
            'params' => [
                'order' => 'position'
            ]]);
        $this->belongsTo('id_part', 'Models\Part', 'id', ['alias' => 'part']);
        $this->belongsTo('id_recipe', 'Models\Recipe', 'id', ['alias' => 'recipe']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipePart[]|RecipePart|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
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
                AND id != ' . $this->getId() . ' 
                AND id_recipe =' . $this->getIdRecipe();
                } else {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position - 1
                WHERE position <=' . $new_position . ' 
                AND position > ' . $old_position . ' 
                AND id != ' . $this->getId() . ' 
                AND id_recipe =' . $this->getIdRecipe();
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

    public function beforeDelete()
    {
        if ($this->count('id_recipe='.$this->getIdRecipe()) === 1) {
            $this->appendMessage(new Message('can_not_delete_last_part'));
            return false;
        }
    }
    public function afterDelete()
    {
        $db = Di::getDefault()->get('db');
        $sql = 'UPDATE tc_recipe_part SET `position` = (`position` - 1) WHERE `position` > ' . $this->getPosition() . ' AND id_recipe=' . $this->getIdRecipe();
        $db->execute($sql);
    }

    public function afterCreate()
    {
        $recipe_ingredient = new RecipeIngredient();
        $recipe_ingredient->setIdRecipe($this->getIdRecipe());
        $recipe_ingredient->setIdRecipePart($this->getId());
        $recipe_ingredient->save();
    }

}

<?php

namespace Models;

use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\ResultsetInterface;

class CategoryFeature extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id_category;

    /**
     *
     * @var integer
     */
    protected $id_feature;

    /**
     *
     * @var integer
     */
    protected $position;

    /**
     * Method to set the value of field id_category
     *
     * @param integer $id_category
     * @return $this
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }

    /**
     * Method to set the value of field id_feature
     *
     * @param integer $id_feature
     * @return $this
     */
    public function setIdFeature($id_feature)
    {
        $this->id_feature = $id_feature;

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
     * Returns the value of field id_category
     *
     * @return integer
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }

    /**
     * Returns the value of field id_feature
     *
     * @return integer
     */
    public function getIdFeature()
    {
        return $this->id_feature;
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
        $this->setSource('tc_category_feature');
        $this->keepSnapshots(true);
        $this->belongsTo('id_category', 'Models\Category', 'id', ['alias' => 'category']);
        $this->belongsTo('id_feature', 'Models\Feature', 'id', ['alias' => 'feature']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoryFeature[]|CategoryFeature|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null) :ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoryFeature|\Phalcon\Mvc\Model\ResultInterface
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
            'id_category' => 'id_category',
            'id_feature' => 'id_feature',
            'position' => 'position'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->setPosition(CategoryFeature::count('id_category='.$this->getIdCategory()) + 1);
    }

    public function afterSave()
    {
        if ($this->hasSnapshotData()) {
            if ($this->hasChanged('position')) {
                $old_position = $this->getSnapshotData()['position'];
                $new_position = $this->getPosition();
                if ($old_position > $new_position) {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position + 1
                WHERE position >=' . $new_position . ' 
                AND position < ' . $old_position . ' 
                AND id_category = ' . $this->getIdCategory().' AND id_feature !='.$this->getIdFeature();
                } else {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position - 1
                WHERE position <=' . $new_position . ' 
                AND position > ' . $old_position . ' 
                AND id_category = ' . $this->getIdCategory().' AND id_feature !='.$this->getIdFeature();
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

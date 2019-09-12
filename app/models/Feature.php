<?php

namespace Models;

use Phalcon\Mvc\Model\Message;

class Feature extends BaseModel
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
    protected $position;

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
        $this->keepSnapshots(true);
        $this->hasOne('id', 'Models\FeatureLang', 'id_feature',
            [
                'alias' => 'lang',
                'params' => [
                    'id_lang=' . Context::getInstance()->getLang()->id
                ]
            ]);
        $this->hasMany('id', 'Models\FeatureLang', 'id_feature', ['alias' => 'langs']);
        $this->hasMany('id', 'Models\FeatureValue', 'id_feature', ['alias' => 'values']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_features';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Feature[]|Feature|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Feature|\Phalcon\Mvc\Model\ResultInterface
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
            'position' => 'position',
            'active' => 'active',
            'date_add' => 'date_add'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->setPosition(Feature::count() + 1);
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
                AND id != ' . $this->getId();
                } else {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position - 1
                WHERE position <=' . $new_position . ' 
                AND position > ' . $old_position . ' 
                AND id != ' . $this->getId();
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
        if ($this->getLangs()) {
            $this->getLangs()->delete();
        }
        if ($this->getValues()) {
            $this->getValues()->delete();
        }
    }
}

<?php

namespace Models;

use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\ResultsetInterface;


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
        $this->setSource('tc_features');
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
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Feature[]|Feature|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null):ResultsetInterface
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

    public static function getFeatures()
    {
        $id_lang = Context::getInstance()->getLang()->getId();
        $sql = 'SELECT f.id as id_feature,fv.id as id_feature_value,fl.value as feature, fvl.value as feature_value FROM tc_features f
            LEFT JOIN tc_feature_values fv ON f.id = fv.id_feature
            LEFT JOIN tc_feature_lang fl ON f.id = fl.id_feature
            LEFT JOIN tc_feature_value_lang fvl ON fv.id = fvl.id_feature_value
            WHERE fvl.id_lang = '.$id_lang.' AND fl.id_lang = '.$id_lang.'
            ORDER BY f.id';
        $model = new self;
        $rows = new \Phalcon\Mvc\Model\Resultset\Simple(
            null,
            $model,
            $model->getReadConnection()->query($sql)
        );
        $result = [];
        if ($rows->count()){
            $rows = $rows->toArray();
            foreach ($rows as $row) {
                $result[$row['id_feature']]['id_feature'] = $row['id_feature'];
                $result[$row['id_feature']]['value'] = $row['feature'];
                $result[$row['id_feature']]['feature_values'][$row['id_feature_value']] = [
                    'id_feature_value' => $row['id_feature_value'],
                    'value' => $row['feature_value'],
                ];
//                $result[$row->id_feature]['id_feature'] = $row->id_feature;
//                $result[$row->id_feature]['value'] = $row->feature;
//                $result[$row->id_feature]['feature_values'][$row->id_feature_value] = [
//                    'id_feature_value' => $row->id_feature_value,
//                    'value' => $row->feature_value,
//                ];
            }
        }

        return $result;
    }
}

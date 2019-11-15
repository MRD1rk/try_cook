<?php

namespace Models;

class FeatureRecipe extends BaseModel
{

    /**
     *
     * @primary
     * @var integer
     */
    protected $id_feature;

    /**
     *
     * @primary
     * @var integer
     */
    protected $id_recipe;

    /**
     *
     * @primary
     * @var integer
     */
    protected $id_feature_value;

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
     * Method to set the value of field id_feature_value
     *
     * @param integer $id_feature_value
     * @return $this
     */
    public function setIdFeatureValue($id_feature_value)
    {
        $this->id_feature_value = $id_feature_value;

        return $this;
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
     * Returns the value of field id_recipe
     *
     * @return integer
     */
    public function getIdRecipe()
    {
        return $this->id_recipe;
    }

    /**
     * Returns the value of field id_feature_value
     *
     * @return integer
     */
    public function getIdFeatureValue()
    {
        return $this->id_feature_value;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_feature_value', 'Models\FeatureValue', 'id', ['alias' => 'featureValue']);
        $this->belongsTo('id_feature', 'Models\Feature', 'id', ['alias' => 'feature']);
        $this->belongsTo('id_recipe', 'Models\Recipe', 'id', ['alias' => 'recipe']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_feature_recipe';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return FeatureRecipe[]|FeatureRecipe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return FeatureRecipe|\Phalcon\Mvc\Model\ResultInterface
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
            'id_feature' => 'id_feature',
            'id_recipe' => 'id_recipe',
            'id_feature_value' => 'id_feature_value'
        ];
    }

}

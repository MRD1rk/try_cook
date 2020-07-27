<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class MediaAdditional extends BaseModel
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
    protected $id_media;

    /**
     *
     * @var string
     */
    protected $link;

    /**
     *
     * @var string
     */
    protected $params;

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
     * Method to set the value of field id_media
     *
     * @param integer $id_media
     * @return $this
     */
    public function setIdMedia($id_media)
    {
        $this->id_media = $id_media;

        return $this;
    }

    /**
     * Method to set the value of field link
     *
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Method to set the value of field params
     *
     * @param string $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;

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
     * Returns the value of field id_media
     *
     * @return integer
     */
    public function getIdMedia()
    {
        return $this->id_media;
    }

    /**
     * Returns the value of field link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Returns the value of field params
     *
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_recipe_media_additional');
        $this->belongsTo('id_media', 'Models\RecipeMedia', 'id', ['alias' => 'source']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MediaAdditional[]|MediaAdditional|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null):ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MediaAdditional|\Phalcon\Mvc\Model\ResultInterface
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
            'id_media' => 'id_media',
            'link' => 'link',
            'params' => 'params'
        ];
    }

}

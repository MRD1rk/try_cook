<?php

namespace Models;

use Helpers\Tools;
use Phalcon\Security;

class TokenStorage extends BaseModel
{

    const TOKEN_EXPIRES = 60 * 60 * 24 * 7;
    const SERIES_EXPIRES = 60 * 60 * 24 * 30;
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @var string
     */
    protected $series;

    /**
     *
     * @var integer
     */
    protected $expires;

    /**
     *
     * @var string
     */
    protected $ip;

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
     * Method to set the value of field type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Method to set the value of field series
     *
     * @param string $series
     * @return $this
     */
    public function setSeries($series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Method to set the value of field expires
     *
     * @param integer $expires
     * @return $this
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Method to set the value of field ip
     *
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

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
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of field token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Returns the value of field series
     *
     * @return string
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Returns the value of field expires
     *
     * @return integer
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Returns the value of field ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
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
        $this->setSchema("try_cook_db");
        $this->setSource("token_storage");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'token_storage';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TokenStorage[]|TokenStorage|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TokenStorage|\Phalcon\Mvc\Model\ResultInterface
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
            'type' => 'type',
            'token' => 'token',
            'series' => 'series',
            'expires' => 'expires',
            'ip' => 'ip',
            'date_add' => 'date_add'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $expires = time() + self::TOKEN_EXPIRES;//7 days
        $random = new Security\Random();
        $token = $random->hex(32);
        $series = $random->hex(32);
        $this->token = $token;
        $this->series = $series;
        $this->expires = $expires;
    }

    public function refreshToken()
    {
        $expires = time() + self::TOKEN_EXPIRES;//7 days
        $random = new Security\Random();
        $token = $random->hex(32);
        $this->token = $token;
        $this->expires = $expires;
        $this->save();
    }

    public function checkSeries()
    {

    }

}

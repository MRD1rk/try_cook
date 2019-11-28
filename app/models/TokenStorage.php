<?php

namespace Models;

use Helpers\Tools;
use Phalcon\Security;

class TokenStorage extends BaseModel
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $id_user;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $user_agent;
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
     * Method to set the value of field id_user
     *
     * @param string $id_user
     * @return $this
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;

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
     * @param string $user_agent
     * @return $this
     */
    public function setUserAgent($user_agent)
    {
        $this->user_agent = $user_agent;

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
     * Returns the value of field id_user
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->id_user;
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
    public function getUserAgent()
    {
        return $this->user_agent;
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
        $this->belongsTo('id_user',   'Models\Users', 'id', [
            'alias' => 'user'
        ]);
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
            'id_user'=>'id_user',
            'token' => 'token',
            'ip' => 'ip',
            'user_agent' => 'user_agent',
            'date_add' => 'date_add'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->date_add = date('Y-m-d H:i:s');
    }


}

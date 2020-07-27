<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class FailedLogins extends \Phalcon\Mvc\Model
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
    protected $id_user;

    /**
     *
     * @var string
     */
    protected $ip;

    /**
     *
     * @var integer
     */
    protected $attempted;

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
     * @param integer $id_user
     * @return $this
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;

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
     * Method to set the value of field attempted
     *
     * @param integer $attempted
     * @return $this
     */
    public function setAttempted($attempted)
    {
        $this->attempted = $attempted;

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
     * @return integer
     */
    public function getIdUser()
    {
        return $this->id_user;
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
     * Returns the value of field attempted
     *
     * @return integer
     */
    public function getAttempted()
    {
        return $this->attempted;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("failed_logins");
        $this->belongsTo('id_user', 'Models\TcUsers', 'id', ['alias' => 'TcUsers']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return FailedLogins[]|FailedLogins|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null) :ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return FailedLogins|\Phalcon\Mvc\Model\ResultInterface
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
            'id_user' => 'id_user',
            'ip' => 'ip',
            'attempted' => 'attempted'
        ];
    }

}

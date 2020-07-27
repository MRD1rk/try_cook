<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class Resource extends BaseModel
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
    protected $id_role;

    /**
     *
     * @var string
     */
    protected $controller;

    /**
     *
     * @var string
     */
    protected $module;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $action_list;

    /**
     *
     * @var string
     */
    protected $date_add;

    /**
     *
     * @var string
     */
    protected $date_upd;

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
     * Method to set the value of field id_role
     *
     * @param integer $id_role
     * @return $this
     */
    public function setIdRole($id_role)
    {
        $this->id_role = $id_role;

        return $this;
    }

    /**
     * Method to set the value of field controller
     *
     * @param string $controller
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Method to set the value of field module
     *
     * @param string $module
     * @return $this
     */
    public function setModule($module)
    {
        $this->module = $module;

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
     * Method to set the value of field action_list
     *
     * @param string $action_list
     * @return $this
     */
    public function setActionList($action_list)
    {
        $this->action_list = $action_list;

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
     * Method to set the value of field date_upd
     *
     * @param string $date_upd
     * @return $this
     */
    public function setDateUpd($date_upd)
    {
        $this->date_upd = $date_upd;

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
     * Returns the value of field id_role
     *
     * @return integer
     */
    public function getIdRole()
    {
        return $this->id_role;
    }

    /**
     * Returns the value of field controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the value of field module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
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
     * Returns the value of field action_list
     *
     * @return string
     */
    public function getActionList()
    {
        return $this->action_list;
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
     * Returns the value of field date_upd
     *
     * @return string
     */
    public function getDateUpd()
    {
        return $this->date_upd;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_acl_resources');
        $this->belongsTo('id_role', 'Models\Role', 'id', ['alias' => 'role']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Resource[]|Resource|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null):ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Resource|\Phalcon\Mvc\Model\ResultInterface
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
            'id_role' => 'id_role',
            'controller' => 'controller',
            'module' => 'module',
            'type' => 'type',
            'action_list' => 'action_list',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }

}

<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Security;
use Phalcon\Security\Random;
use Phalcon\Validation;

/**
 * @property int logged
 */
class User extends BaseModel
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
    protected $firstname;

    /**
     *
     * @var string
     */
    protected $lastname;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $activation_code;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     * @var integer
     */
    protected $active;
    /**
     *
     * @var string
     */
    protected $date_upd;

    /**
     *
     * @var string
     */
    protected $date_add;
    /**
     * @var false|string
     */
    protected $last_login;

    /**
     * @var int
     */
    protected $logged = 0;

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
     * Method to set the value of field firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Method to set the value of field lastname
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field activation_code
     *
     * @param string $activation_code
     * @return $this
     */
    public function setActivationCode($activation_code)
    {
        $this->activation_code = $activation_code;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $security = new \Phalcon\Security();
        $password = $security->hash($password);
        $this->password = $password;

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
     * Method to set the value of field password
     *
     * @param integer $last_login
     * @return $this
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
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
     * Method to set the value of field logged
     *
     * @param integer $logged
     * @return $this
     */
    public function setLogged($logged)
    {
        $this->logged = $logged;

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
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Returns the value of field lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field activation_code
     *
     * @return string
     */
    public function getActivationCode()
    {
        return $this->activation_code;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return false|string
     */
    public function getLastLogin()
    {
        return $this->last_login;
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
     * Returns the value of field date_add
     *
     * @return string
     */
    public function getDateAdd()
    {
        return $this->date_add;
    }

    /**
     * Returns the value of field logged
     * @return int
     */
    public function getLogged()
    {
        return $this->logged;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add('email',
            new Validation\Validator\Email([
                'model' => $this,
                'message' => 'incorrect_email'
            ]));
        $validator->add('email',
            new Validation\Validator\Uniqueness(
                [
                    'model' => $this,
                    'message' => 'user_with_this_email_already_exists'
                ]
            ));
        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('tc_users');
        $this->hasMany('id', 'Models\Recipe', 'id_user', ['alias' => 'recipes']);
        $this->hasOne('id', 'Models\Recipe', 'id_user', [
            'alias' => 'draftRecipe',
            'conditions' => 'state = \'draft\''
        ]);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null) :ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
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
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'email' => 'email',
            'activation_code' => 'activation_code',
            'password' => 'password',
            'active' => 'active',
            'last_login' => 'last_login',
            'date_upd' => 'date_upd',
            'date_add' => 'date_add'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $random = new Random();
        $code = $random->hex();
        $this->setActivationCode($code);
    }

    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }


}

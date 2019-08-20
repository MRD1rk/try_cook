<?php

namespace Models;


final class Context extends BaseModel
{
    /**
     * @var Context
     */
    protected static $instance;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var Employee
     */
    protected $employee;
    /**
     * @var Lang
     */
    protected $lang;

    /**
     * @return Context
     */
    public static function getInstance()
    {
        if (!self::$instance)
            self::$instance = new Context();
        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getEmployee()
    {
        if (isset($this->employee))
            return $this->employee;
        $authData = $this->getDI()->getSession()->get('employee_data');
        $employee = null;
        if (!empty($authData)) {
            $employee = Employee::findFirstById($authData['id']);
            if ($employee) {
                $employee->setLogged(1);
            } else
                $employee = new Employee();
        } else {
            $employee = new Employee();
        }
        $this->employee = $employee;
        return $this->employee;

    }

    public function setEmployee($employee)
    {
        $this->employee = $employee;
        return $this;
    }

    /**
     * @return Lang
     */
    public function getLang()
    {
        if ($this->lang)
            return $this->lang;
        $lang_iso = $this->getDI()->getDispatcher()->getParam('iso_code');
        $lang = Lang::findFirstByIsoCode($lang_iso);
        if (!$lang)
            $lang = Lang::findFirstById(Configuration::get('DEFAULT_ID_LANG'));
        $this->setLang($lang);
        return $this->getLang();
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang): void
    {
        $this->lang = $lang;
    }
}
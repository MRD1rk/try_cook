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
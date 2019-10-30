<?php

namespace Models;

use Helpers\Tools;

class CategoryLang extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id_category;

    /**
     *
     * @var integer
     */
    protected $id_lang;

    /**
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @var string
     */
    protected $link_rewrite;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     * Method to set the value of field id_category
     *
     * @param integer $id_category
     * @return $this
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }

    /**
     * Method to set the value of field id_lang
     *
     * @param integer $id_lang
     * @return $this
     */
    public function setIdLang($id_lang)
    {
        $this->id_lang = $id_lang;

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $link_rewrite
     * @return $this
     */
    public function setLinkRewrite($link_rewrite)
    {
        $this->link_rewrite = $link_rewrite;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns the value of field id_category
     *
     * @return integer
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }

    /**
     * Returns the value of field id_lang
     *
     * @return integer
     */
    public function getIdLang()
    {
        return $this->id_lang;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getLinkRewrite()
    {
        return $this->link_rewrite;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_category', 'Models\Category', 'id', ['alias' => 'category']);
        $this->belongsTo('id_lang', 'Models\Lang', 'id', ['alias' => 'lang']);
    }

    /**
     * Returns table title mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_category_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoryLang[]|CategoryLang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoryLang|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real titles in the table and the values their titles in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id_category' => 'id_category',
            'id_lang' => 'id_lang',
            'title' => 'title',
            'link_rewrite' => 'link_rewrite',
            'description' => 'description'
        ];
    }

    public function beforeValidationOnCreate()
    {
        $this->setLinkRewrite(Tools::strToUrl($this->gettitle()));
    }

}

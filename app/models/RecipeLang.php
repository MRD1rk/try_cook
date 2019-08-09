<?php

namespace Models;

class RecipeLang extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id_recipe;

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
    protected $description;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $link_rewrite;

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
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param $link_rewrite
     * @return $this
     */
    public function setLinkRewrite($link_rewrite)
    {
        $this->link_rewrite = $link_rewrite;

        return $this;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getLinkRewrite()
    {
        return $this->link_rewrite;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_lang', 'Models\Lang', 'id', ['alias' => 'lang']);
        $this->belongsTo('id_recipe', 'Models\Recipe', 'id', ['alias' => 'recipe']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_recipe_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeLang[]|RecipeLang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeLang|\Phalcon\Mvc\Model\ResultInterface
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
            'id_recipe' => 'id_recipe',
            'id_lang' => 'id_lang',
            'title' => 'title',
            'description' => 'description',
            'content' => 'content',
            'link_rewrite' => 'link_rewrite'
        ];
    }

}

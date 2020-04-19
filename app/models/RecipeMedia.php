<?php

namespace Models;


use Components\ImageManager;

class RecipeMedia extends BaseModel
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
    protected $id_recipe;

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var integer
     */
    protected $position;

    /**
     *
     * @var integer
     */
    protected $cover;

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
     * Method to set the value of field position
     *
     * @param integer $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Method to set the value of field cover
     *
     * @param integer $cover
     * @return $this
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

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
     * Returns the value of field id_recipe
     *
     * @return integer
     */
    public function getIdRecipe()
    {
        return $this->id_recipe;
    }

    /**
     * Returns the value of field active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
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
     * Returns the value of field position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Returns the value of field cover
     *
     * @return integer
     */
    public function getCover()
    {
        return $this->cover;
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
        $this->hasMany('id', MediaAdditional::class, 'id_media', ['alias' => 'mediaAdditional']);
        $this->belongsTo('id_recipe', Recipe::class, 'id', ['alias' => 'recipe']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_recipe_media';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeMedia[]|RecipeMedia|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeMedia|\Phalcon\Mvc\Model\ResultInterface
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
            'id_recipe' => 'id_recipe',
            'active' => 'active',
            'type' => 'type',
            'position' => 'position',
            'cover' => 'cover',
            'date_add' => 'date_add'
        ];
    }


    public function getPath($type = '')
    {
        $root_path = ImageManager::getRootPath() . ImageManager::$recipe_image_dir . DIRECTORY_SEPARATOR ;
        $delimiter = '';
        if ($type)
            $delimiter = '-';
        $extension = 'jpeg';
        $path = str_split((string)$this->getId());
        $path = implode('/', $path);
        $path = $path . DIRECTORY_SEPARATOR . $this->getId() . $delimiter . $type;
        $path = $path . '.' . $extension;
        $path = $root_path . $path;
        return $path;
    }

    public function getLink($type = 'image', $image_type = 'default', $alias = 'recipe', $absolute = false)
    {
        $url = '';
        switch ($type) {
            case 'image':
                $url = '/r/' . $this->getId() . '-' . $image_type . '/' . $alias . '.jpeg';
                if ($absolute)
                    $url = Configuration::get('HTTP_SCHEME') . '://' . Configuration::get('DOMAIN') . $url;
                break;
        }
        return $url;
    }
}

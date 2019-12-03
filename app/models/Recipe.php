<?php

namespace Models;


use Components\ImageManager;
use Phalcon\Mvc\Model\Message;

class Recipe extends BaseModel
{

    /**
     * @var array Allowed image extension
     */
    protected $allow_extension = ['png', 'jpg', 'jpeg'];
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $default_person_count;

    /**
     *
     * @var integer
     */
    protected $cooking_time;

    /**
     * @var int
     */
    protected $prepare_time;

    /**
     * @var string
     */
    protected $id_user;

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     *
     * @var string
     */
    protected $state;

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
     * Method to set the value of field default_person_count
     *
     * @param integer $default_person_count
     * @return $this
     */
    public function setDefaultPersonCount($default_person_count)
    {
        $this->default_person_count = $default_person_count;

        return $this;
    }

    /**
     * Method to set the value of field cooking_time
     *
     * @param integer $cooking_time
     * @return $this
     */
    public function setCookingTime($cooking_time)
    {
        $this->cooking_time = $cooking_time;

        return $this;
    }

    /**
     * Method to set the value of field cooking_time
     *
     * @param integer $prepare_time
     * @return $this
     */
    public function setPrepareTime($prepare_time)
    {
        $this->prepare_time = $prepare_time;

        return $this;
    }

    /**
     * Method to set the value of field active
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
     * Method to set the value of field state
     *
     * @param integer $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

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
     * Returns the value of field default_person_count
     *
     * @return integer
     */
    public function getDefaultPersonCount()
    {
        return $this->default_person_count;
    }

    /**
     * Returns the value of field cooking_time
     *
     * @return integer
     */
    public function getCookingTime()
    {
        return $this->cooking_time;
    }

    /**
     * Returns the value of field cooking_time
     *
     * @return integer
     */
    public function getPrepareTime()
    {
        return $this->prepare_time;
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
     * Returns the value of field state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Returns the value of field active
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->id_user;
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
        $this->hasManyToMany('id', 'Models\CategoryRecipe', 'id_recipe', 'id_category', 'Models\Category', 'id', ['alias' => 'categories']);
        $this->hasMany('id', 'Models\RecipeIngredient', 'id_recipe', ['alias' => 'ingredients']);
        $this->hasOne('id_user', 'Models\User', 'id', ['alias' => 'author']);
        $this->hasOne('id', 'Models\RecipeLang', 'id_recipe', [
            'alias' => 'lang',
            'params' => [
                'id_lang=' . Context::getInstance()->getLang()->id
            ]
        ]);
        $this->hasMany('id', 'Models\FeatureRecipe', 'id_recipe', ['alias' => 'recipeFeatures']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_recipes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Recipe[]|Recipe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Recipe|\Phalcon\Mvc\Model\ResultInterface
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
            'default_person_count' => 'default_person_count',
            'cooking_time' => 'cooking_time',
            'prepare_time' => 'prepare_time',
            'difficulty' => 'difficulty',
            'id_user' => 'id_user',
            'active' => 'active',
            'state' => 'state',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }

    /**
     * Update recipe's feature
     * @param $features array
     * @return bool
     */
    public function updateFeature($features)
    {
        if (!$features)
            return false;
        $this->getRecipeFeatures()->delete();
        foreach ($features as $id_feature => $id_feature_value) {
            $recipe_feature = new FeatureRecipe();
            $recipe_feature->setIdRecipe($this->getId());
            $recipe_feature->setIdFeature($id_feature);
            $recipe_feature->setIdFeatureValue($id_feature_value);
            if (!$recipe_feature->save())
                return false;
        }
        return true;
    }

    public function uploadPreviewImage($files)
    {
        foreach ($files as $file) {
            if (!in_array($file->getExtension(), $this->allow_extension)) {
                $message = new Message('no_allowed_extension');
                $this->appendMessage($message);
                return false;
            }
            $image = new Media();
            $image->setType('image');
            $image->setIdRecipe($this->getId());
            $image->setActive(1);
            if (!$image->save()) {
                $message = new Message('failed_image_save');
                $this->appendMessage($message);
                return false;
            }
            ImageManager::createPath($image->getId());
            ImageManager::saveOriginal($file, $image->getPath());
            ImageManager::resize($image);
        }
    }

}

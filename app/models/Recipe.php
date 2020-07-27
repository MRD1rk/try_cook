<?php

namespace Models;


use Components\ImageManager;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\ResultsetInterface;

class Recipe extends BaseModel
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
        $this->setSource('tc_recipes');
        $this->hasManyToMany('id', 'Models\CategoryRecipe', 'id_recipe', 'id_category', 'Models\Category', 'id', ['alias' => 'categories']);
        $this->hasMany('id',CategoryRecipe::class,'id_recipe',['alias'=>'recipeCategories']);
        $this->hasMany('id', 'Models\RecipeIngredient', 'id_recipe', ['alias' => 'ingredients',
            'params' => [
                'order' => 'position'
            ]
        ]);
        $this->hasOne('id_user', 'Models\User', 'id', ['alias' => 'author']);
        $this->hasOne('id', 'Models\RecipeLang', 'id_recipe', [
            'alias' => 'lang',
            'params' => [
                'id_lang=' . Context::getInstance()->getLang()->getId()
            ]
        ]);
        $this->hasMany('id', 'Models\RecipeMedia', 'id_recipe', [
            'alias' => 'images',
            'params' => [
                'type = "image"',
                'order' => 'cover DESC'
            ]
        ]);
        $this->hasMany('id', 'Models\FeatureRecipe', 'id_recipe', ['alias' => 'recipeFeatures']);
        $this->hasMany('id', RecipeLang::class, 'id_recipe', ['alias' => 'langs']);
        $this->hasMany('id', 'Models\RecipeStep', 'id_recipe', ['alias' => 'steps']);
        $this->hasMany('id', 'Models\RecipePart', 'id_recipe', ['alias' => 'parts',
            'params' => [
                'order' => 'position'
            ]
        ]);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Recipe[]|Recipe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
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
            if (!$recipe_feature->save()) {
                $this->appendMessage(new Message('failed_save_recipe_features'));
                return false;
            }
        }
        return true;
    }

    /**
     * @param $recipe_lang_data
     * @return bool
     */
    public function updateRecipeLang($recipe_lang_data)
    {
        if (!$recipe_lang_data)
            return false;
        $recipe_lang = $this->getLang();
        $recipe_lang->setTitle($recipe_lang_data['title']);
        $recipe_lang->setDescription($recipe_lang_data['description']);
        if (!$recipe_lang->save()) {
            $this->appendMessage(new Message('failed_save_recipe_lang'));
            return false;
        }
        return true;
    }

    public function updateCategory($id_category) {
        if (!$id_category)
            return false;
        $this->getRecipeCategories()->delete();
        $category_recipe = new CategoryRecipe();
        $category_recipe->setIdCategory($id_category);
        $category_recipe->setIdRecipe($this->getId());
        if (!$category_recipe->save()) {
            $this->appendMessage(new Message('failed_save_recipe_category'));
            return false;
        }
        return true;

    }
    public function uploadPreviewImage($files)
    {
        foreach ($files as $file) {
            if (!in_array($file->getExtension(), ImageManager::$allowedImageExtensions)) {
                $message = new Message('no_allowed_extension');
                $this->appendMessage($message);
                return false;
            }
            $image = isset($this->getImages()[0]) ? $this->getImages()[0] : new RecipeMedia();//get object with cover = 1(preview)
            $image->setType('image');
            $image->setIdRecipe($this->getId());
            $image->setActive(1);
            $image->setCover(1);
            if (!$image->save()) {
                $message = new Message('failed_image_save');
                $this->appendMessage($message);
                return false;
            }
            ImageManager::saveOriginal($file, $image->getPath());
            ImageManager::resize($image->getPath());
            return $image;
        }
    }

    public function beforeDelete()
    {
        $this->getParts()->delete();
        $this->getImages()->delete();
        $this->getSteps()->delete();
        $this->getLangs()->delete();
    }

    public function afterSave()
    {
        $recipe_step = new RecipeStep();
        $recipe_step->setIdRecipe($this->getId());
        $recipe_step->save();
    }

    /**
     * Check if user can update this recipe
     * @return bool
     */
    public function allowEdit()
    {
        $current_user = Context::getInstance()->getUser();
        return $current_user->getId() === $this->getIdUser();
    }

    public function getIngredientsData()
    {
        $result = [];
        $ingredients = $this->getRelated('ingredients');
        foreach ($ingredients as $ingredient) {
            $result[$ingredient->getId()] = $ingredient->getPosition();
        }
        return $result;
    }

    public function getPartsData()
    {
        $result = [];
        $parts = $this->getRelated('parts');
        foreach ($parts as $part) {
            $result[$part->getId()] = $part->getPosition();
        }
        return $result;
    }

    /**
     * @return Simple
     * @todo change or delete this method.
     */
    public function getRecipe()
    {
        $id_lang = Context::getInstance()->getLang()->getId();
        $sql = 'SELECT 
                GROUP_CONCAT(u.id) AS id_units,
                GROUP_CONCAT(ul.title) as unit_title,
                GROUP_CONCAT(i.id) AS id_ingredients,
                GROUP_CONCAT(il.title) AS ingredient_title,
                r.* FROM tc_recipes r
                LEFT JOIN tc_recipe_lang rl ON r.id = rl.id_recipe
                LEFT JOIN tc_recipe_part rp ON r.id = rp.id_recipe
                LEFT JOIN tc_part_lang pl ON rp.id = pl.id_part AND pl.id_lang= ' . $id_lang . '
                LEFT JOIN tc_recipe_ingredient ri ON r.id = ri.id_recipe AND ri.id_recipe_part = rp.id
                LEFT JOIN tc_ingredients i ON i.id = ri.id_ingredient
                LEFT JOIN tc_ingredient_lang il ON i.id = il.id_ingredient AND il.id_lang = ' . $id_lang . '
                LEFT JOIN tc_units u ON u.id = ri.id_unit
                LEFT JOIN tc_unit_lang ul ON u.id = ul.id_unit AND ul.id_lang = ' . $id_lang . '
                WHERE r.id = ' . $this->getId() . ' AND rl.id_lang = ' . $id_lang;
        $rows = new Simple(
            null,
            $this,
            $this->getReadConnection()->query($sql)
        );

        $result = [];

        foreach ($rows->toArray() as $row) {
            $ids_unit = explode(',', $row['id_units']);
            $unit_titles = explode(',', $row['unit_title']);
            $ids_id_ingredient = explode(',', $row['id_ingredients']);
            $ingredient_titles = explode(',', $row['ingredient_title']);
            $units = [];
            $ingredients = [];
            foreach ($ids_id_ingredient as $key => $item) {
                $ingredients[$item] = $ingredient_titles[$key];
                $units[$ids_unit[$key]] = $unit_titles[$key];
            }
            $result = [
                'id_recipe' => $row['id'],
                'units' => $units,
                'ingredients' => $ingredients
            ];
            echo '<pre>';
            var_dump($result);
            die();
        }
        return $rows;
    }
}

<?php

namespace Models;

use Components\ImageManager;
use Phalcon\Di;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\ResultsetInterface;

class RecipeStep extends BaseModel
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
    protected $position;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $src;

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
     * Method to set the value of field src
     *
     * @param string $src
     * @return $this
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Method to set the value of field src
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
     * Returns the value of field position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
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
     * Returns the value of field src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
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
        $this->setSource('tc_recipe_steps');
        $this->hasMany('id', 'Models\RecipeStepLang', 'id_step', ['alias' => 'langs']);
        $this->hasOne('id', 'Models\RecipeStepLang', 'id_step',
            [
                'alias' => 'lang',
                'params' => 'id_lang=' . Context::getInstance()->getLang()->getId()
            ]);
        $this->belongsTo('id_recipe', 'Models\Recipe', 'id', ['alias' => 'recipe']);
    }


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeStep[]|RecipeStep|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RecipeStep|\Phalcon\Mvc\Model\ResultInterface
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
            'position' => 'position',
            'type' => 'type',
            'src' => 'src',
            'date_add' => 'date_add'
        ];
    }


    public function beforeValidationOnCreate()
    {
        $this->setPosition(RecipeStep::count('id_recipe=' . $this->getIdRecipe()) + 1);
    }

    public function uploadImage($files)
    {
        foreach ($files as $file) {
            if (!in_array($file->getExtension(), ImageManager::$allowedImageExtensions)) {
                $message = new Message('no_allowed_extension');
                $this->appendMessage($message);
                return false;
            }
            $path = $this->getImagePath();

            ImageManager::saveOriginal($file, $path);
            ImageManager::resize($path);
            return true;
        }
    }

    public function getImagePath($type = '')
    {
        $root_path = ImageManager::getRootPath() . ImageManager::$recipe_step_image_dir . DIRECTORY_SEPARATOR;
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

    public function getLink($image_type = 'default', $alias = 'recipe_step', $absolute = false)
    {
        if (!file_exists($this->getImagePath($image_type)))
            return false;
        $url = '/rs/' . $this->getId() . '-' . $image_type . '/' . $alias . '.jpeg';
        if ($absolute)
            $url = Configuration::get('HTTP_SCHEME') . '://' . Configuration::get('DOMAIN') . $url;

        return $url;
    }

    public function beforeDelete()
    {
        if ($this->count('id_recipe='.$this->getIdRecipe()) === 1) {
            $this->appendMessage(new Message('can_not_delete_last_part'));
            return false;
        }
        if ($this->getLang())
            $this->getLang()->delete();
        $image_types = ImageType::find('active=1');
        foreach ($image_types as $image_type) {
            if (file_exists($this->getImagePath($image_type->getType())))
                unlink($this->getImagePath($image_type->getType()));
        }
        if (file_exists($this->getImagePath()))
            unlink($this->getImagePath());

        $db = Di::getDefault()->get('db');
        $sql = 'UPDATE tc_recipe_steps SET `position` = (`position` - 1) WHERE `position` > ' . $this->getPosition() . ' AND id_recipe=' . $this->getIdRecipe();
        $db->execute($sql);
    }

}

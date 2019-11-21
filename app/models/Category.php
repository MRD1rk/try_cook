<?php

namespace Models;

use Phalcon\Http\Request\File;
use Phalcon\Image\Adapter\Imagick;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Category extends BaseModel
{

    /**
     * @var array Allowed image extension
     */
    protected $allow_extension = ['png', 'jpg', 'jpeg'];

    protected $icon_path = BASE_PATH . '/img/category/';
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $id_parent;

    /**
     *
     * @var integer
     */
    protected $position;

    /**
     *
     * @var integer
     */
    protected $active;

    /**
     *
     * @var integer
     */
    protected $level_depth;

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
     * Method to set the value of field id_parent
     *
     * @param integer $id_parent
     * @return $this
     */
    public function setIdParent($id_parent)
    {
        $this->id_parent = $id_parent;

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
     * Method to set the value of field active
     *
     * @param integer $level_depth
     * @return $this
     */
    public function setLevelDepth($level_depth)
    {
        $this->level_depth = $level_depth;

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
     * Returns the value of field id_parent
     *
     * @return integer
     */
    public function getIdParent()
    {
        return $this->id_parent;
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
     * Returns the value of field active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Returns the value of field level_depth
     *
     * @return integer
     */
    public function getLevelDepth()
    {
        return $this->level_depth;
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
        $this->keepSnapshots(true);
        $this->hasOne('id', 'Models\CategoryLang', 'id_category', [
            'alias' => 'lang',
        ]);
        $this->hasManyToMany(
            'id', 'Models\CategoryFeature', 'id_category',
            'id_feature', 'Models\Feature', 'id',
            [
                'alias' => 'features'
            ]);
        $this->hasManyToMany(
            'id', 'Models\CategoryRecipe', 'id_category',
            'id_recipe', 'Models\Recipe', 'id',
            [
                'alias' => 'recipes'
            ]);
        $this->hasMany('id', 'Models\CategoryLang', 'id_category', ['alias' => 'langs']);
        $this->hasMany('id', 'Models\CategoryRecipe', 'id_category', ['alias' => 'categoryRecipes']);
        $this->hasMany('id', 'Models\CategoryFeature', 'id_category', ['alias' => 'categoryFeatures']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_categories';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]|Category|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category|\Phalcon\Mvc\Model\ResultInterface
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
            'id_parent' => 'id_parent',
            'position' => 'position',
            'active' => 'active',
            'level_depth' => 'level_depth',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }

    private function getIconPath()
    {
        $extension = 'jpg';
        $type = 'default';
        $filename = $this->getId() . '-' . $type . '.' . $extension;
        $filepath = $this->icon_path . $filename;
        return $filepath;
    }

    public function uploadIcon(File $file)
    {
        if (!in_array($file->getExtension(), $this->allow_extension)) {
            $message = new Message('no_allowed_extension');
            $this->appendMessage($message);
            return false;
        }
        $imagick = new Imagick($file->getTempName());
        $imagick->background('#ffffff');
        $filepath = $this->getIconPath();
        $result = $imagick->save($filepath);
        if (!$result) {
            $message = new Message('failure_upload');
            $this->appendMessage($message);
            return false;
        }
        return true;
    }


    public function afterDelete()
    {
        $filepath = $this->getIconPath();
        if (file_exists($filepath))
            unlink($filepath);
    }

    public function beforeValidationOnCreate()
    {
        $this->setPosition(Category::count() + 1);
    }

    public function afterSave()
    {
        if ($this->hasSnapshotData()) {
            if ($this->hasChanged('position')) {
                $old_position = $this->getSnapshotData()['position'];
                $new_position = $this->getPosition();
                if ($old_position > $new_position) {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position + 1
                WHERE position >=' . $new_position . ' 
                AND position < ' . $old_position . ' 
                AND id != ' . $this->getId();
                } else {
                    $phql = 'UPDATE ' . $this->getSource() . ' SET position = position - 1
                WHERE position <=' . $new_position . ' 
                AND position > ' . $old_position . ' 
                AND id != ' . $this->getId();
                }
                if (!$result = $this->getWriteConnection()->query($phql)) {
                    $message = new Message('sql query error (position). Result: ' . var_dump($result));
                    $this->appendMessage($message);
                    return false;
                }
            }
            return true;
        }
    }

    public function getCategoryFeatures($selected_features = [])
    {
        $id_lang = Context::getInstance()->getLang()->id;
        $conditions[] = 'cf.id_category = ' . $this->getId();
        $conditions[] = 'fvl.id_lang = ' . $id_lang;
        $conditions[] = 'fl.id_lang = ' . $id_lang;
        $ids_feature_value[] = 'null';//need for mysql query.If create empty array - implode function ignore this element and in query will be IN () => error
        if (!empty($selected_features['features'])) {
            foreach ($selected_features['features'] as $id_feature => $selected_feature) {
                $ids_feature_value = [];
                $ids_feature_value = array_merge($ids_feature_value, $selected_feature);
                $ids_feature_value = array_unique($ids_feature_value);
            }
        }

        $sql = 'SELECT *,CASE WHEN sub.id_recipes IS NULL THEN 0 WHEN FIND_IN_SET(id_recipe ,sub.id_recipes) = 0 THEN 1 ELSE 0 END AS disabled
					 FROM (
					    SELECT fr.id_feature, fl.value AS feature, fr.id_feature_value ,fvl.value AS feature_value, cf.id_category,fr.id_recipe,
                        COUNT(fr.id_feature_value) AS count_recipes,
                        (SELECT GROUP_CONCAT(id_recipe) FROM tc_feature_recipe frr 
                         WHERE frr.id_feature_value IN(' . implode(',', $ids_feature_value) . ')) AS id_recipes
                            FROM tc_category_recipe  cr
                                INNER JOIN tc_category_feature cf ON cr.id_category = cf.id_category
                                LEFT JOIN tc_feature_recipe fr ON (fr.id_feature = cf.id_feature AND fr.id_recipe = cr.id_recipe)
                                LEFT JOIN tc_feature_lang fl ON fl.id_feature = cf.id_feature
                                LEFT JOIN tc_feature_value_lang fvl ON fvl.id_feature_value = fr.id_feature_value
                                WHERE cf.id_category = '.$this->getId().' AND fvl.id_lang = '.$id_lang.' AND fl.id_lang = '.$id_lang.'
                                GROUP BY fvl.id_feature_value, cf.id_feature,fr.id_recipe
                                ORDER BY cf.position ASC, fr.id_feature ASC, fvl.value ASC) AS sub';
        $model = new Recipe();
        $rows = new Resultset(
            null,
            $model,
            $model->getReadConnection()->query($sql)
        );
        $result = [];
        if ($rows->count()) {
            $rows = $rows->toArray();
            $count = [];
            foreach ($rows as $row) {
                $count[$row['id_feature_value']] = ($count[$row['id_feature_value']] ?? 0) + $row['count_recipes'];
                $result[$row['id_feature']]['id_feature'] = $row['id_feature'];
                $result[$row['id_feature']]['value'] = $row['feature'];
                $result[$row['id_feature']]['feature_values'][$row['id_feature_value']] = [
                    'id_feature_value' => $row['id_feature_value'],
                    'value' => $row['feature_value'],
                    'disabled' => $row['disabled'] ?? 0,
                    'count' => $count[$row['id_feature_value']]
                ];
            }
        }


        return $result;
    }

    public function getRecipesByFilter($filters = [], $page = 1, $limit = 0, $order = '')
    {
        $id_lang = Context::getInstance()->getLang()->id;
        $conditions[] = 'rl.id_lang=' . $id_lang;
        if (!empty($filters['features'])) {
            $ids_feature = [];
            $ids_feature_value = [];
            foreach ($filters['features'] as $id_feature => $selected_feature) {
                $ids_feature[] = $id_feature;
                $ids_feature_value = array_merge($selected_feature,$ids_feature_value);
            }
            $conditions[] = 'fr.id_feature IN (' . implode(',', $ids_feature) . ')';
            $conditions[] = 'fr.id_feature_value IN (' . implode(',', $ids_feature_value) . ')';
        }
        $sql = 'SELECT r.id, r.id_user, r.date_add, rl.title, rl.description, rl.link_rewrite
                 FROM tc_recipes r
                 LEFT JOIN tc_recipe_lang rl ON r.id = rl.id_recipe
                 LEFT JOIN tc_feature_recipe fr ON r.id = fr.id_recipe
                 WHERE ' . implode(' AND ', $conditions) . '
                 GROUP BY r.id';
        echo '<pre>';
        var_dump($sql);
        die();
        $model = new Recipe();
        $recipes = new Resultset(
            null,
            $model,
            $model->getReadConnection()->query($sql)
        );
        return $recipes;
    }

    public function getCountRecipesByFilter($filters = [])
    {

        $conditions[] = 'cr.id_category=' . $this->getId();
        if (!empty($filters['features'])) {
            foreach ($filters['features'] as $id_feature => $selected_feature) {
                $conditions[] = 'fr.id_feature = ' . $id_feature;
                $conditions[] = 'fr.id_feature_value IN (' . implode(',', $selected_feature) . ')';
            }
        }
        $phql = 'SELECT COUNT(DISTINCT fr.id_recipe) as recipes_count FROM Models\FeatureRecipe fr
                 LEFT JOIN Models\CategoryRecipe cr ON cr.id_recipe=fr.id_recipe
                 WHERE ' . implode(' AND ', $conditions);
        $model = new Category();
        $query = new Query($phql, $model->getDI());
        $rows = $query->getSingleResult();
        return $rows['recipes_count'];
    }
}

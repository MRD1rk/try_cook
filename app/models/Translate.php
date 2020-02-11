<?php

namespace Models;

use Phalcon\Cache\Backend\Redis;
use \Phalcon\Mvc\Model\Query;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Translate extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $pattern;

    /**
     *
     * @var string
     */
    protected $category;

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
     * Method to set the value of field pattern
     *
     * @param string $pattern
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Method to set the value of field pattern
     *
     * @param string $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

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
     * Returns the value of field pattern
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Returns the value of field category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
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

        $this->hasMany('id', 'Models\TranslateLang', 'id_translation', ['alias' => 'langs']);
        $this->hasOne('id', 'Models\TranslateLang', 'id_translation', [
            'alias' => 'lang'
            ]);
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'pattern',
            new Validation\Validator\Uniqueness(
                [
                    'model' => $this,
                    'message' => 'pattern_must_be_unique',
                ]
            )
        );

        return $this->validate($validator);
    }
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tc_translates';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Translate[]|Translate|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Translate|\Phalcon\Mvc\Model\ResultInterface
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
            'pattern' => 'pattern',
            'category' => 'category',
            'date_add' => 'date_add'
        ];
    }

    public static function getTranslationsByCategory($category)
    {
        $model = new self();
        $di = $model->getDI();
        $redis = $di->get('redis');
        $id_lang = \Models\Context::getInstance()->getLang()->id;
        $translates = $redis->get('translation_' . $category . '_' . $id_lang);
        if (!$translates) {
            $phql = 'SELECT t.pattern, tl.value FROM Models\Translate t
                     LEFT JOIN Models\TranslateLang tl ON t.id= tl.id_translation AND tl.id_lang=' . $id_lang . ' 
                     WHERE t.category IN(' . $category . ')';
            $query = new Query($phql, $di);
            $rows = $query->execute();
            if ($rows->count()) {
                foreach ($rows as $row) {
                    $translates[$row->pattern] = $row->value;
                }
                unset($rows);
//                $redis->save('translation_'.$category.'_' . $id_lang, $translates, 360);
                $redis->save('translation_' . $category . '_' . $id_lang, $translates, 1);
            } else
                $translates = [];
        }
        return $translates;
    }

    public static function getTranslates()
    {
        $model = new self();
        $di = $model->getDI();
        /** @var Redis $redis */
        $redis = $di->get('redis');
        $id_lang = \Models\Context::getInstance()->getLang()->id;
        $translates = $redis->get('translation_' . $id_lang);
        if (!$translates) {
            $phql = 'SELECT t.pattern, tl.value FROM Models\Translate t
                     LEFT JOIN Models\TranslateLang tl ON t.id= tl.id_translation AND tl.id_lang=' . $id_lang;
            $query = new Query($phql, $di);
            $rows = $query->execute();
            if ($rows->count()) {
                foreach ($rows as $row) {
                    $translates[$row->pattern] = $row->value;
                }
                unset($rows);
//                $redis->save('translation_' . $id_lang, $translates, 360);
                $redis->save('translation_' . $id_lang, $translates, 1);
            } else
                $translates = [];
        }
        return $translates;
    }

    public function beforeDelete()
    {
        if ($this->getLangs()) {
            $this->getLangs()->delete();
        }
    }
}

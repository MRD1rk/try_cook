<?php

namespace Models;

use Phalcon\Mvc\Model\ResultsetInterface;

class TranslateLang extends BaseModel
{

    /**
     *
     * @Primary
     * @var integer
     */
    protected $id_translation;

    /**
     *
     * @Primary
     * @var integer
     */
    protected $id_lang;

    /**
     *
     * @var string
     */
    protected $value;

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
     * Method to set the value of field id_translation
     *
     * @param integer $id_translation
     * @return $this
     */
    public function setIdTranslation($id_translation)
    {
        $this->id_translation = $id_translation;

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
     * Method to set the value of field value
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

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
     * Returns the value of field id_translation
     *
     * @return integer
     */
    public function getIdTranslation()
    {
        return $this->id_translation;
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
     * Returns the value of field value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
        $this->setSource('tc_translate_lang');
        $this->skipAttributesOnCreate(
            [
                'date_upd'
            ]
        );

        // Skips only when updating
        $this->skipAttributesOnUpdate(
            [
                'date_add'
            ]
        );
        $this->belongsTo('id_lang', 'Models\Lang', 'id', ['alias' => 'lang']);
        $this->belongsTo('id_translation', 'Models\Translate', 'id', ['alias' => 'translate']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TranslateLang[]|TranslateLang|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null) :ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TranslateLang|\Phalcon\Mvc\Model\ResultInterface
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
            'id_translation' => 'id_translation',
            'id_lang' => 'id_lang',
            'value' => 'value',
            'date_add' => 'date_add',
            'date_upd' => 'date_upd'
        ];
    }

    public function beforeValidation()
    {
        $this->setDateUpd(date('Y-m-d H:i:s'));
    }



}

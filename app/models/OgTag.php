<?php

namespace Models;

class OgTag
{
    protected $og_content = [];

    public $empty = true;

    public function __construct()
    {
        $site_name = Configuration::get('SITE_NAME');
        if($site_name){
            $this->og_content['site_name'] = $site_name;
        }
        $this->og_content['type'] = 'website';
        $current_lang = Context::getInstance()->getLang();
        $lang_code = explode('-',$current_lang->lang_code);
        $this->og_content['locale'] = $lang_code[0].'_'.strtoupper($lang_code[1]);
        $langs = Lang::find('id != '.$current_lang->id);
        foreach ($langs as $lang){
            $lang_code = explode('-',$lang->lang_code);
            $this->og_content['locale:alternate'] = $lang_code[0].'_'.strtoupper($lang_code[1]);
        }
//        $this->og_content['image']="//aquamarket.ua/themes/aqumarket/img/logo.png";
        $this->og_content['image']="";
    }

    public function __get($property)
    {
        return $this->getProperty($property);
    }

    public function __set($property, $content)
    {
        if (!$property) return false;
        if (!$content) $content = '';
        $content = htmlentities(strip_tags($content));
        $this->og_content[$property] = $content;
        $this->empty = false;
        return true;
    }

    public function getProperty($property, $bool=true)
    {
        if (!$property || !isset($this->og_content[$property])){
            return false;
        }
        $content = $this->og_content[$property];
        if ($bool) {
            return '<meta property="og:' . $property . '" content="' . $content . '"/>';
        }
        return $content;
    }

    public function getAll($bool=true)
    {
        if($this->empty) return false;
        if($bool){
            $tags_str = '';
            foreach ($this->og_content as $property => $content){
                $tag = '<meta property="og:' . $property . '" content="' . $content . '"/>';
                $tags_str .= $tag.PHP_EOL;
            }
            return $tags_str;
        }
        return $this->og_content;
    }

}
<?php

namespace Components;


use Models\Configuration;
use Models\Context;
use Phalcon\Url;

class UrlManager extends Url
{
    private $server_path = ROOT_PATH.'/public';
    protected $domain_url;

    public function __construct()
    {
        $this->domain_url = Configuration::get('DOMAIN');
    }

//    public function get($uri = null, $args = null, bool $absolute = null, $baseUri = null): string
//    {
//        $url = parent::get($uri, $args, $absolute, $baseUri);
//        if ($absolute)
//            $url = $this->domain_url . '/' . $url;
//        return rtrim($url);
//    }

    /**
     * @param $id_category
     * @param string $link_rewrite
     * @param bool $absolute
     * @return string url for category
     */
    public function getCategoryLink($id_category, $link_rewrite = 'category', $absolute = false)
    {
        $iso_code = Context::getInstance()->getLang()->iso_code;
        $url = '/' . $iso_code . '/' . $id_category . '-' . $link_rewrite;
        if ($absolute)
            $url = $this->domain_url . $url;
        return $url;
    }

    public function getCategoryIconLink($id_category, $type = 'default', $link_rewrite = 'category', $absolute = false)
    {
        $extension = 'jpg';
        $url = '/c/' . $id_category . '-' . $type . '/' . $link_rewrite . '.' . $extension;
        if ($absolute)
            $url = $this->domain_url . $url;
        return $url;
    }

    public function getRecipeImage($id_image, $image_type = 'default', $alias = 'recipe', $absolute = false)
    {
        $url = DIRECTORY_SEPARATOR . ImageManager::$recipe_image_dir . DIRECTORY_SEPARATOR.$id_image . '-' . $image_type . '/' . $alias . '.jpeg';
        if ($absolute)
            $url = Configuration::get('HTTP_SCHEME') . '://' . Configuration::get('DOMAIN') . $url;
        return $url;
    }
}
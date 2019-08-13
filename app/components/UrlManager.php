<?php

namespace Components;


use Models\Configuration;
use Models\Context;
use Phalcon\Mvc\Url;

class UrlManager extends Url
{
    protected $domain_url;

    public function __construct()
    {
        $this->domain_url = Configuration::get('DOMAIN');
    }

    public function get($uri = null, $args = null, $absolute = null, $baseUri = null)
    {
        $url = parent::get($uri, $args, $absolute, $baseUri);
        if ($absolute)
            $url = $this->domain_url . '/' . $url;
        return $url;
    }

    public function getCategoryLink($id_category, $link_rewrite = 'category', $absolute = false)
    {
        $iso_code = Context::getInstance()->getLang()->iso_code;
        $url = '/' . $iso_code . '/' . $id_category . '-' . $link_rewrite;
        if ($absolute)
            $url = Configuration::get('DOMAIN') . $url;
        return $url;
    }
}
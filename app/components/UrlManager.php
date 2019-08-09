<?php

namespace Components;


use Models\Configuration;
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
            $uri = $this->domain_url . '/' . $url;
        return $uri;
    }
}
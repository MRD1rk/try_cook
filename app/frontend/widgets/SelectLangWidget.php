<?php


namespace Modules\Frontend\Widgets;


use Models\Configuration;
use Models\Context;
use Models\Lang;

class SelectLangWidget extends BaseWidget
{
    protected $view_dir = 'selectLang';

    public function run($view = 'header')
    {
        $request = $this->getDi()->get('request');
        $domain = Configuration::get('DOMAIN');
        $current_uri = $domain.$request->getUri();
        $current_lang = Context::getInstance()->getLang();
        $current_iso_code = $current_lang->getIsoCode();
        $langs = Lang::find('active=1');
        $urls_langs = [];
        foreach ($langs as $lang){
            $urls_langs[$lang->getId()] = Configuration::get('HTTP_SCHEME').'://'. str_replace($domain.'/'.$current_iso_code,$domain.'/'.$lang->getIsoCode(),$current_uri);
        }
        $this->view->current_lang = $current_lang;
        $this->view->urls_langs = $urls_langs;
        $this->view->langs = $langs;
        return $this->render($view);

    }
}
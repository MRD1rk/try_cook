<?php

namespace Modules\Frontend\Controllers;


use Helpers\Tools;
use Models\Ingredient;
use Models\IngredientLang;
use Models\Translate;
use Models\User;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $this->assets->collection('headerCss')->addCss('/css/recipes-slider.css');
        $this->assets->collection('headerCss')->addCss('/vendor/slick/slick.css');
        $this->assets->collection('headerCss')->addCss('/vendor/slick/slick-theme.css');
        $this->assets->collection('footerJs')->addJs('vendor/slick/slick.min.js');
        $this->assets->collection('footerJs')->addJs('js/index.js');
//        $this->view->container_class = '';
    }


    public function getTranslationsAction()
    {
        if ($this->request->isAjax()) {
            $status = false;
            $data = null;
            $category = $this->request->getPost('category');
            $category = implode(',', array_map(function ($value) {
                $value = Tools::striptags($value);
                return $this->db->escapeString($value);
            }, $category));
            $translations = Translate::getTranslationsByCategory($category);
            if ($translations) {
                $status = true;
                $data = $translations;
            }
            return $this->response->setJsonContent(['status' => $status, 'data' => $data]);
        }
    }
}


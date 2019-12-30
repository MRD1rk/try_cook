<?php

namespace Modules\Frontend\Controllers;

use Models\Category;
use Models\Context;
use Models\Feature;
use Models\Recipe;
use Models\Unit;

class RecipesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->container_class = 'container-lg';
        $this->assets->collection('headerCss')->addCss('css/recipes.css');
    }

    public function indexAction()
    {
        $categories = Category::find(['conditions' => 'active =1 AND id_parent=0']);
        $this->view->categories = $categories;
    }

    public function newAction()
    {
        $user = Context::getInstance()->getUser();
        $iso_code = Context::getInstance()->getLang()->iso_code;
        $drafted_recipe = $user->getDraftRecipe();
        if (!$drafted_recipe) {
            $drafted_recipe = new Recipe();
            $drafted_recipe->setIdUser($user->getId());
            $drafted_recipe->save();
        }
        return $this->response->redirect($this->url->get(['for' => 'recipes-add', 'iso_code' => $iso_code, 'id_recipe' => $drafted_recipe->getId()]));
    }

    public function addAction()
    {
        $this->view->container_class = 'container';
        $this->tag->setTitle($this->t->_('add-recipe'));
        $this->assets->collection('headerCss')->addCss('vendor/selectize/css/selectize.css');
        $this->assets->collection('footerJs')->addJs('vendor/selectize/js/standalone/selectize.min.js');
        $this->assets->collection('footerJs')->addJs('vendor/tinymce/tinymce.min.js');
        $this->assets->collection('footerJs')->addJs('js/recipes.js');
        $user = Context::getInstance()->getUser();
        $iso_code = Context::getInstance()->getLang()->iso_code;
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        if (!$id_recipe) {
            return $this->response->redirect($this->url->get(['for' => 'recipes-index', 'iso_code' => $iso_code]));
        }
        $recipe = Recipe::findFirst(['id = :id: AND id_user = :id_user:',
            'bind' => [
                'id' => $id_recipe,
                'id_user' => $user->getId()
            ]]);
        if (!$recipe) {
            return $this->response->redirect($this->url->get(['for' => 'recipes-index', 'iso_code' => $iso_code]));
        }
        $categories = Category::find(['conditions' => 'active =1 AND id_parent=0']);
        $features = Feature::getFeatures();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $data = $this->request->getPost();
        }

        $this->view->recipe = $recipe;
        $this->view->features = $features;
        $this->view->categories = $categories;
    }

    public function uploadImageAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $id_recipe = $this->request->getPost('id_recipe', 'int');
            $type = $this->request->getPost('type');
            $files = $this->request->getUploadedFiles();
            if (!$files) {
                return $this->response->setJsonContent(['status' => false, 'message' => $this->t->_('failed_upload')]);
            }
            switch ($type) {
                case'recipe_image':
                    $recipe = Recipe::findFirst($id_recipe);
                    $image = $recipe->uploadPreviewImage($files);
                    break;
            }
            return $this->response->setJsonContent(['status' => true, 'url' => $image->getLink('image', 'default')]);
        }
    }

    public function viewAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }
}
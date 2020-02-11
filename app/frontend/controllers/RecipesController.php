<?php

namespace Modules\Frontend\Controllers;

use Helpers\Tools;
use Models\Category;
use Models\Context;
use Models\Feature;
use Models\Recipe;
use Models\RecipeStep;
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
        $iso_code = Context::getInstance()->getLang()->getIsoCode();
        $user = Context::getInstance()->getUser();
        if (!$user->getId()) {
            $this->view->force_login_modal = true;
            $this->session->set('login_redirect_url', $this->url->get(['for' => 'recipes-new', 'iso_code' => $iso_code]));
            $this->flash->error($this->t->_('you_must_be_logged'));
            return $this->dispatcher->forward(['action' => 'index', 'params' => ['iso_code' => $iso_code]]);
        }
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
        $this->tag->setTitle($this->t->_('add_new_recipe'));
        $this->assets->collection('headerCss')->addCss('vendor/selectize/css/selectize.css');
        $this->assets->collection('headerCss')->addCss('vendor/jquery-ui-1.12.1/jquery-ui.min.css');
        $this->assets->collection('footerJs')->addJs('vendor/selectize/js/standalone/selectize.min.js');
        $this->assets->collection('footerJs')->addJs('vendor/tinymce/tinymce.min.js');
        $this->assets->collection('footerJs')->addJs('vendor/jquery-ui-1.12.1/jquery-ui.min.js');
        $this->assets->collection('footerJs')->addJs('js/recipes.js');
        $this->assets->collection('footerJs')->addJs('js/dragManager.js');
        $user = Context::getInstance()->getUser();
        $iso_code = Context::getInstance()->getLang()->getIsoCode();
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
//            $id_recipe = $this->request->getPost('id_recipe', 'int');
            $id_recipe = $this->dispatcher->getParam('id_recipe');
            $files = $this->request->getUploadedFiles();
            if (!$files) {
                return $this->response->setJsonContent(['status' => false, 'message' => $this->t->_('failed_upload')]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            $image = $recipe->uploadPreviewImage($files);

            return $this->response->setJsonContent(['status' => true, 'url' => $image->getLink('image', 'default')]);
        }
    }

    /**
     * Create new recipe's step
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function addRecipeStepAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe_step = new RecipeStep();
            $recipe_step->setIdRecipe($recipe->getId());
            if ($recipe_step->save()) {
                $status = true;
                $message = $this->t->_('successfully');
                $content = $this->view->getPartial('recipes/recipe-step-item', ['step' => $recipe_step]);
                $id_step = $recipe_step->getId();
                return $this->response->setJsonContent(
                    [
                        'status' => $status,
                        'message' => $message,
                        'content' => $content,
                        'id_step' => $id_step
                    ]);
            }
        }
    }

    public function deleteRecipeStepAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $message = '';
            $id_recipe = $this->dispatcher->getParam('id_recipe');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_step = $this->dispatcher->getParam('id_step');
            $recipe_step = RecipeStep::findFirst($id_step);
            if (!$recipe_step->delete()) {
                foreach ($recipe_step->getMessages() as $error) {
                    $message[] = $error->getMessage();
                }
                return $this->response->setJsonContent(['status' => $status, 'message' => Tools::arrToString($message)]);
            }
            $status = true;
            $message = $this->t->_('successfully');
            return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
        }

    }

    public function uploadStepImageAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $id_recipe = $this->dispatcher->getParam('id_recipe');
            $id_step = $this->request->getPost('id_step');
            $files = $this->request->getUploadedFiles();
            if (!$files) {
                return $this->response->setJsonContent(['status' => false, 'message' => $this->t->_('failed_upload')]);
            }
            $step = RecipeStep::findFirst($id_step);
        }
    }

    public function viewAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }
}
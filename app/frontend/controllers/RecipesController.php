<?php

namespace Modules\Frontend\Controllers;

use Helpers\Tools;
use Models\Category;
use Models\Context;
use Models\Feature;
use Models\Ingredient;
use Models\RecipeMedia;
use Models\Part;
use Models\Recipe;
use Models\RecipeIngredient;
use Models\RecipePart;
use Models\RecipeStep;

class RecipesController extends BaseController
{
    public function initialize()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', null);
        if ($id_recipe) {
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => false, 'message' => $message]);
            }
        }
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
        if (!$user->getLogged()

        ) {
            $this->view->force_login_modal = true;
            $this->session->set('login_redirect_url', $this->url->get(['for' => 'recipes-new', 'iso_code' => $iso_code]));
            $this->flash->error($this->t->_('you_must_be_logged'));
            $this->dispatcher->forward(['action' => 'index', 'params' => ['iso_code' => $iso_code]]);
        }
        $drafted_recipe = $user->getDraftRecipe();
        if (!$drafted_recipe) {
            $drafted_recipe = new Recipe();
            $drafted_recipe->setIdUser($user->getId());
            $drafted_recipe->save();
        }
        return $this->response->redirect($this->url->get(['for' => 'recipes-form', 'iso_code' => $iso_code, 'id_recipe' => $drafted_recipe->getId()]));
    }

    public function formAction()
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
        $this->assets->collection('footerJs')->addJs('js/plugins/myValidation.js');
        $user = Context::getInstance()->getUser();
        $lang = Context::getInstance()->getLang();
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        if (!$id_recipe) {
            return $this->response->redirect($this->url->get(['for' => 'recipes-index', 'iso_code' => $lang->getIsoCode()]));
        }
        $recipe = Recipe::findFirst(['id = :id: AND id_user = :id_user:',
            'bind' => [
                'id' => $id_recipe,
                'id_user' => $user->getId()
            ]]);
        if (!$recipe) {
            return $this->response->redirect($this->url->get(['for' => 'recipes-index', 'iso_code' => $lang->getIsoCode()]));
        }
        $categories = Category::find(['conditions' => 'active = 1 AND id_parent = 0']);
        $features = Feature::getFeatures();
        $parts = Part::getParts();
        $recipe_parts = $recipe->getParts();

        $images = $recipe->getImages();
        //begin save
        if ($this->request->isPost() && $this->request->isAjax()) {
            $state = $this->request->getPost('draft', null, Recipe::RECIPE_STATUS_CHECK);
            $recipe_data = $this->request->getPost('recipe');
            $recipe->setCookingTime($recipe_data['cooking_time']);
            $recipe->setPrepareTime($recipe_data['prepare_time']);
            $recipe->setState($state);
            $recipe->setDefaultPersonCount($recipe_data['default_person_count']);
            $id_category = $this->request->getPost('id_category');
            if ($recipe->updateFeature($this->request->getPost('features', null, []))
                && $recipe->updateRecipeLang($this->request->getPost('recipe_lang', null, []))
                && $recipe->updateCategory($id_category)
                && $recipe->updateStep($this->request->getPost('steps', null, []))
                && $recipe->save()
            ) {
                $status = true;
                $message = $this->t->_('recipe_saved');
            } else {
                $status = false;
                $message = Tools::arrToString($recipe->getMessages());
            }
            return $this->response->setJsonContent([
                'status' => $status,
                'message' => $message,
                'url' => $this->url->get([
                    'for' => 'recipes-view',
                    'iso_code' => $lang->getIsoCode(),
                    'id_recipe' => $recipe->getId(),
                    'link_rewrite' => $recipe->getLang()->getLinkRewrite()
                ])
            ]);
        }
        $this->view->recipe = $recipe;
        $this->view->parts = $parts;
        $this->view->ingredients = [];
        $this->view->recipe_parts = $recipe_parts;
        $this->view->images = $recipe->getImages();
        $this->view->cover = isset($images[0]) ? $images[0] : new RecipeMedia();
        $this->view->features = $features;
        $this->view->categories = $categories;
    }

    public function addRecipePartAction()
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
            $parts = Part::getParts();
            $recipe_part = new RecipePart();
            $recipe_part->setIdRecipe($recipe->getId());
            if ($recipe_part->save()) {
                $status = true;
                $message = $this->t->_('recipe_part_added');
                $content = $this->view->getPartial('recipes/recipe-part-item', ['recipe_part' => $recipe_part, 'parts' => $parts]);
                return $this->response->setJsonContent([
                    'content' => $content,
                    'position' => $recipe_part->getPosition(),
                    'status' => $status,
                    'message' => $message
                ]);
            }
        }
    }


    /**
     * Update recipePart
     */
    public function updateRecipePartAction()
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
            $id_recipe_part = $this->request->getPost('id_recipe_part');
            $id_part = $this->request->getPost('id_part');
            $recipe_part = RecipePart::findFirst($id_recipe_part);
            $recipe_part->setIdPart($id_part);
            if ($recipe_part->save()) {
                $status = true;
                $message = $this->t->_('recipe_part_updated');
                return $this->response->setJsonContent([
                    'status' => $status,
                    'message' => $message,
                    'id_part' => $recipe_part->getId()
                ]);
            }
        }
    }

    /**
     * Delete recipePart
     */
    public function deleteRecipePartAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $data = [];
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
            $id_recipe_part = $this->dispatcher->getParam('id_recipe_part');
            $recipe_part = RecipePart::findFirst($id_recipe_part);
            if (!$recipe_part->delete()) {
                $message = Tools::arrToString($recipe_part->getMessages());
                $status = false;
            } else {
                $data = $recipe->getPartsData();
                $status = true;
                $message = $this->t->_('recipe_part_deleted');
            }
            return $this->response->setJsonContent([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ]);
        }
    }

    /**
     * Add new RecipeIngredient
     */
    public function addRecipeIngredientAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_recipe_part = $this->request->getPost('id_recipe_part', 'int');
            $recipe_ingredient = new RecipeIngredient();
            $recipe_ingredient->setIdRecipe($id_recipe);
            $recipe_ingredient->setIdRecipePart($id_recipe_part);
            if (!$recipe_ingredient->save()) {
                $message = $this->t->_(Tools::arrToString($recipe_ingredient->getMessages()));
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $status = true;
            $message = $this->t->_('ingredient_added');
            $content = $this->view->getPartial('recipes/recipe-ingredient-item', ['recipe_ingredient' => $recipe_ingredient]);
            return $this->response->setJsonContent([
                'content' => $content,
                'position' => $recipe_ingredient->getPosition(),
                'status' => $status,
                'message' => $message
            ]);


        }
    }

    public function deleteRecipeIngredientAction()
    {
        $this->view->disable();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_recipe_ingredient = $this->dispatcher->getParam('id_recipe_ingredient', 'int');
            $recipe_ingredient = RecipeIngredient::findFirst($id_recipe_ingredient);
            if ($recipe_ingredient->delete()) {
                $data = $recipe->getIngredientsData();
                $status = true;
                $message = $this->t->_('ingredient_deleted');
                return $this->response->setJsonContent([
                    'status' => $status,
                    'message' => $message,
                    'data' => $data
                ]);
            }

        }
    }

    /**
     * Update RecipeIngredient position
     * @return \Phalcon\Http\ResponseInterface
     */
    public function updateRecipeIngredientPositionAction()
    {

        $this->view->disable();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_recipe_ingredient = $this->dispatcher->getParam('id_recipe_ingredient', 'int');
            $position = $this->request->getPost('position', 'int');
            $recipe_ingredient = RecipeIngredient::findFirst($id_recipe_ingredient);
            $recipe_ingredient->setPosition($position);
            if (!$recipe_ingredient->save()) {
                return $this->response->setJsonContent(['status' => $status, 'message' => Tools::arrToString($recipe_ingredient->getMessages())]);
            } else {
                $status = true;
                $message = $this->t->_('position_updated');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
        }
    }

    /**
     * Update RecipePart position
     * @return \Phalcon\Http\ResponseInterface
     */
    public function updateRecipePartPositionAction()
    {
        $this->view->disable();
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_recipe_part = $this->dispatcher->getParam('id_recipe_part', 'int');
            $position = $this->request->getPost('position', 'int');
            $recipe_part = RecipePart::findFirst($id_recipe_part);
            $recipe_part->setPosition($position);
            $recipe_part->save();
            if (!$recipe_part->save()) {
                return $this->response->setJsonContent(['status' => $status, 'message' => Tools::arrToString($recipe_part->getMessages())]);
            } else {
                $status = true;
                $message = $this->t->_('position_updated');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
        }
    }

    public function updateRecipeIngredientAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
            if (!$id_recipe) {
                $message = $this->t->_('id_recipe_is_required');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_recipe_ingredient = $this->dispatcher->getParam('id_recipe_ingredient', 'int');
            $id_ingredient = $this->request->getPost('id_ingredient', 'int');
            $id_unit = $this->request->getPost('id_unit', 'int');
            $count = $this->request->getPost('count');
            $recipe_ingredient = RecipeIngredient::findFirst($id_recipe_ingredient);
            $recipe_ingredient->setIdIngredient($id_ingredient);
            $recipe_ingredient->setIdUnit($id_unit);
            $recipe_ingredient->setCount($count);
            if (!$recipe_ingredient->save()) {
                $status = false;
                $message = Tools::arrToString($recipe_ingredient->getMessages());
                return $this->response->setJsonContent(
                    [
                        'status' => $status,
                        'message' => $message,
                    ]);
            } else {
                $status = true;
                $message = $this->t->_('ingredient_updated');
                return $this->response->setJsonContent(
                    [
                        'status' => $status,
                        'message' => $message,
                    ]);
            }
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
                $message = $this->t->_('recipe_step_added');
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
                $message = Tools::arrToString($recipe_step->getMessages());
                return $this->response->setJsonContent(['status' => $status, 'message' => Tools::arrToString($message)]);
            }
            $status = true;
            $message = $this->t->_('recipe_step_deleted');
            return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
        }

    }

    public function uploadStepImageAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe');
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $id_step = $this->request->getPost('id_step');
            $files = $this->request->getUploadedFiles();
            if (!$files) {
                return $this->response->setJsonContent(['status' => false, 'message' => $this->t->_('failed_upload')]);
            }
            $recipe_step = RecipeStep::findFirst($id_step);
            $status = $recipe_step->uploadImage($files);
            $response = [
                'status' => $status,
                'url' => $recipe_step->getLink(),
                'message' => $this->t->_('image_added')
            ];

            return $this->response->setJsonContent($response);

        }
    }

    public function uploadImageAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $status = false;
            $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
            $files = $this->request->getUploadedFiles();
            if (!$files) {
                return $this->response->setJsonContent(['status' => $status, 'message' => $this->t->_('failed_upload')]);
            }
            $recipe = Recipe::findFirst($id_recipe);
            if (!$recipe->allowEdit()) {
                $message = $this->t->_('no_access');
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            $image = $recipe->uploadPreviewImage($files);
            if (!$image) {
                $message = Tools::arrToString($recipe->getMessages());
                return $this->response->setJsonContent(['status' => $status, 'message' => $message]);
            }
            return $this->response->setJsonContent(
                [
                    'status' => true,
                    'url' => $image->getLink('image', 'default'),
                    'message' => $this->t->_('image_added')
                ]);
        }
    }

    public function viewAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe', 'int');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }
}
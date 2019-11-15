<?php


namespace Modules\Backend\Controllers;


use Helpers\Tools;
use Models\Feature;
use Models\Recipe;

class RecipesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $recipes = Recipe::find();
        $this->view->recipes = $recipes;
    }

    public function updateAction()
    {
        $id_recipe = $this->dispatcher->getParam('id_recipe');
        $recipe = Recipe::findFirst($id_recipe);
        $this->view->recipe = $recipe;
    }

    public function updateFeatureAction()
    {
        $this->assets->collection('headerCss')->addCss('vendor/selectize/css/selectize.css');
        $this->assets->collection('footerJs')->addJs('vendor/selectize/js/standalone/selectize.min.js');
        $this->assets->collection('footerJs')->addJs('admin-theme/js/recipes.js');
        $id_recipe = $this->dispatcher->getParam('id_recipe');
        $recipe = Recipe::findFirst($id_recipe);
        if ($this->request->isPost()) {
            $post_features = $this->request->getPost('features');
            $post_features = array_filter($post_features);
            $result = $recipe->updateFeature($post_features);
            if (!$result) {
                $this->flash->error($this->t->_('features_failed_updated'));
            } else
                $this->flash->success($this->t->_('features_successfully_updated'));


        }
        $recipe_features = $recipe->getRecipeFeatures()->toArray();
        $recipe_features = Tools::assoc($recipe_features, 'id_feature_value');
        $features = Feature::find();
        $this->view->recipe = $recipe;
        $this->view->features = $features;
        $this->view->recipe_features = $recipe_features;
    }
}
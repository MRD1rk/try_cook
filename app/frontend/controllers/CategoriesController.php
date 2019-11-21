<?php


namespace Modules\Frontend\Controllers;


use Models\Category;
use Phalcon\Mvc\View;

class CategoriesController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->container_class = 'container-lg';
        $this->assets->collection('headerCss')->addCss('css/categories.css');
        $this->assets->collection('footerJs')->addJs('js/categories.js');
    }

    public function indexAction()
    {

    }

    public function viewAction()
    {
        $this->assets->collection('headerCss')->addCss('css/recipes.css');
        $id_category = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id_category);
        $features = $category->getCategoryFeatures();
        $filteredRecipes = $category->getRecipesByFilter();
        $this->view->category = $category;
        $this->view->recipes = $filteredRecipes['recipes'];
        $this->view->total_count = $filteredRecipes['count'];
        $this->view->features = $features;
    }

    public function filterAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $id_category = $this->request->getPost('id_category');
            $category = Category::findFirst($id_category);
            $features = $this->request->getPost('features');
            $input_selected_features = [];
            if ($features) {
                foreach ($features as $feature) {
                    $value = explode('_', $feature);
                    $input_selected_features[$value[0]][] = $value[1];
                }
            }
            $selected['features'] = $input_selected_features;

            $features = $category->getCategoryFeatures($selected);
            $filtered_recipes = $category->getRecipesByFilter($selected);
            $selected_features = $category->getAssocSelectedFeatures($selected, $features);
            $recipes = $this->RecipeListWidget->run('categories-view', $filtered_recipes['recipes']);
            $filter = $this->FilterWidget->run('desktop', $category, $features, $filtered_recipes['count'], $selected_features);
            $response = [
                'status' => true,
                'filter_block' => $filter,
                'recipes_block' => $recipes,
                'selected_features' => $selected_features
            ];
            return $this->response->setJsonContent($response);

        }
    }

}
<?php


namespace Modules\Frontend\Widgets;


use Models\Category;

class FilterWidget extends BaseWidget
{
    public $view_dir = 'filter';

    public function run($view = 'desktop',Category $category = null, $selected = [])
    {
        $features = $category->getCategoryFeatures($selected);
        $selected_features = [];
        if (isset($selected['features']) && !empty($selected['features'])){
            foreach ($selected['features'] as $selected_feature_items) {
                foreach ($selected_feature_items as $value) {
                    $selected_features[$value] = $value;
                }

            }
        }
        $total_recipes = $category->getCountRecipesByFilter($selected);
        $this->view->id_category = $category->getId();
        $this->view->features = $features;
        $this->view->selected_features = $selected_features;
        $this->view->total_recipes = $total_recipes;
        return $this->render($view);
    }
}
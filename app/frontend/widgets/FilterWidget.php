<?php


namespace Modules\Frontend\Widgets;


use Models\Category;

class FilterWidget extends BaseWidget
{
    public $view_dir = 'filter';

    public function run($template = 'desktop', Category $category = null, $features = null, $total_count = 0, $selected_features = [])
    {
        $this->view->id_category = $category->getId();
        $features['features'] = $features;
        $this->view->features = $features;
        $this->view->selected_features = $selected_features;
        $this->view->total_recipes = $total_count;
        return $this->render($template);
    }

}
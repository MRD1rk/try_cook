<?php


namespace Modules\Frontend\Widgets;


use Models\Category;

class FilterWidget extends BaseWidget
{
    public $view_dir = 'filter';

    public function run(Category $category = null, $selected = [], $view = 'desktop')
    {
        $id_category = $category->getId();
        $features = $category->features;
        return $this->render($view);
    }
}
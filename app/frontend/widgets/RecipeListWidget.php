<?php


namespace Modules\Frontend\Widgets;


class RecipeListWidget extends BaseWidget
{
    public $view_dir = 'recipe-list';

    public function run($view = 'category-view', $recipes = null)
    {
        if (!$recipes)
            return '';
        $this->view->recipes = $recipes;
        return $this->render($view);
    }
}
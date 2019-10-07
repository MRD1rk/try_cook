<?php


namespace Modules\Frontend\Widgets;


class PopularRecipesWidget extends BaseWidget
{
    public $view_dir = 'popularRecipes';

    public function run($view = 'slider')
    {
        return $this->render($view);
    }
}
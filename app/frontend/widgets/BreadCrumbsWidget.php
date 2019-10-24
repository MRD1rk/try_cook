<?php


namespace Modules\Frontend\Widgets;


use Models\Recipe;

class BreadCrumbsWidget extends BaseWidget
{
    protected $view_dir = 'breadcrumbs';

    public function run($view = 'nav')
    {

        $controller_name = $this->getDi()->get('router')->getControllerName();
        $action_name = $this->getDi()->get('router')->getActionName();
        $method = $controller_name . '/' . $action_name;
        switch ($method) {
            case 'recipes/view':
                $links = $this->getRecipesLinks();
                break;
            case 'recipes/index':
                $recipe_link['name'] = $this->getDi()->get('t')->_('recipes');
                $recipe_link['link'] = $this->getDi()->getUrl()->get(['for'=>'recipes-index']);
                $links[] = $recipe_link;
        }
        $this->view->breadcrumbs = $links;
        return $this->render($view);

    }

    public function getRecipesLinks()
    {
        $data = [];
        $id_recipe = $this->getDi()->get('dispatcher')->getParam('id_recipe');
        $recipe = Recipe::findFirstById($id_recipe);
        $categories = $recipe->getCategories(['conditions' => 'id > 0', 'order' => 'level_depth']);
        foreach ($categories as $category) {
            $category_data['name'] = $category->lang->getName();
            $category_data['link'] = $this->getDi()->getUrl()->getCategoryLink($category->id, $category->lang->getLinkRewrite());
            $data[] = $category_data;
        }
        $recipe_data['name'] = $recipe->lang->getTitle();
        $data[] = $recipe_data;

        return $data;
    }
}
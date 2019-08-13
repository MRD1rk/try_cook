<?php


namespace Modules\Frontend\Widgets;


use Models\Category;
use Models\Context;
use Models\Recipe;

class BreadCrumbsWidget extends BaseWidget
{
    protected $view_dir = 'breadcrumbs';

    public function run($id_recipe = null, $view = 'nav')
    {

        $controller_name = $this->getDi()->get('router')->getControllerName();
        $action_name = $this->getDi()->get('router')->getActionName();
        $method = $controller_name . '/' . $action_name;
        switch ($method) {
            case 'recipes/view':
                $links = $this->getRecipesLinks();

        }
        $main_category['name'] = $this->getDi()->getT()->_('main');
        $main_category['link'] = $this->getDi()->get('url')->get(['for'=>'index-index','iso_code'=>Context::getInstance()->getLang()->iso_code]);

        $bread_crumbs = array_merge([$main_category], $bread_crumbs);
        $this->view->breadcrumbs = $bread_crumbs;
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
        $data[] = $recipe->lang->getTitle();

        return $data;
    }
}
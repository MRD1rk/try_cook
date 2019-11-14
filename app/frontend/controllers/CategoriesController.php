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
        $id_category = $this->dispatcher->getParam('id_category');
        $category = Category::findFirst($id_category);
        $products = $category->recipes;
        $this->view->category = $category;
        $this->view->products = $products;
    }

    public function filterAction()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        if ($this->request->isPost() && $this->request->isAjax()) {
            $id_category = $this->request->getPost('id_category');
            $category = Category::findFirst($id_category);
            $features = $this->request->getPost('features');
            $selected_features = [];
            if ($features) {
                foreach ($features as $feature) {
                    $value = explode('_', $feature);
                    $selected_features[$value[0]][] = $value[1];
                }
            }
            $selected['features'] = $selected_features;
            $filter = $this->FilterWidget->run($category, $selected);
            $response = [
                'status' => true,
                'filter_block' => $filter
            ];
            return $this->response->setJsonContent($response);

        }
    }
}
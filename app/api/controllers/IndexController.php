<?php

namespace Modules\Api\Controllers;


use Components\Search;
use Models\Ingredient;
use Models\Unit;

class IndexController extends BaseController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {

    }

    public function getIngredientsAction()
    {
        $query = $this->request->getPost('query', 'string');
        $ids = (new Search())->query($query);
        $ingredients = Ingredient::getIngredient(['ids' => $ids]);
        $datas = [];
        foreach ($ingredients as $ingredient) {
            $data['id'] = $ingredient['i']->getId();
            $data['name'] = $ingredient['il']->getTitle();
            $data['unit_available'] = json_decode($ingredient['i']->getUnitAvailable());
            $datas[] = $data;
//        }
        }
        $response['status'] = true;
        $response['data'] = $datas;
        return $this->response->setJsonContent($response);
    }

    public function getUnitsAction()
    {
        $units_values = $this->request->getPost('units');
        $units = Unit::getUnits($units_values);
        $datas = [];
        foreach ($units as $unit) {
            $data['value'] = $unit['id'];
            $data['title'] = $unit['title'];
            $datas[] = $data;
//        }
        }
        $response['status'] = true;
        $response['data'] = $datas;
        return $this->response->setJsonContent($response);
    }
    public function getRecipePartAction()
    {

    }
}


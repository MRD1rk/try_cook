<?php

namespace Tasks;

use Models\Ingredient;
use Models\IngredientLang;

class ImportTask extends MainTask
{
    public function indexAction()
    {

        $url = 'https://www.edimdoma.ru/retsepty/ingredients/filter';// create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        $data = json_decode($output);
        foreach ($data as $datum) {
            $exist = Ingredient::findFirst('old_id=' . $datum->id);
            $units = $this->mapUnit($datum->validAmountTypes);
            $units = array_values($units);
            if (!$exist) {
                $ingredient = new Ingredient();
                $ingredient->setActive(1);
                $ingredient->setOldId($datum->id);
                $ingredient->setUnitAvailable(json_encode($units));
                if ($ingredient->save()) {
                    $description = $this->getDescription($datum->id);
                    echo $datum->id . ' ' . $description . "\n\r";
                    $ingredient_lang = new IngredientLang();
                    $ingredient_lang->setTitle($datum->name);
                    $ingredient_lang->setIdLang(1);
                    $ingredient_lang->setIdIngredient($ingredient->getId());
                    $ingredient_lang->setDescription($description);
                    if (!$ingredient_lang->save()){
                        echo '<pre>';
                        var_dump($ingredient_lang->getMessages());
                        die();
                    }
                }
            } else {
                $exist->setUnitAvailable(serialize($units));
                $exist->save();
            }
        }
    }

    public function mapUnit($values)
    {
        $units = [
            1 => 11,
            22 => 12,
            4 => 1,
            21 => 2,
            7 => 3,
            12 => 10,
            13 => 4,
            27 => 5,
            18 => 14,
            25 => 7,
            24 => 8,
            26 => 9,
            29 => 15,
            30 => 6,
            11 => 18,
            28 => 20,
            6 => 19,
            32 => 21,
            10 => 22,
            16 => 23,
            20 => 24,
            34 => 25,
            5 => 26,
            17 => 17,
            14 => 27,
            9 => 28,
            2 => 29,
            33 => 30,
            19 => 31,
            8 => 32,
            23 => 33,
            36 => 34,
            31 => 35,
            15 => 36,
            35 => 37,
            3 => 38,


        ];
        $res = array_intersect(array_flip($units), $values);
        $result = array_flip($res);
        return $result;
    }

    public function getDescription($id)
    {
        $url = 'https://www.edimdoma.ru/encyclopedia/ingredients/';
        $description = '';
        $dom = new \DOMDocument();
        @$dom->loadHTML(file_get_contents($url . $id . '-te'));
//        $dom->loadHTML(file_get_contents('https://www.edimdoma.ru/encyclopedia/ingredients/1049-perets-sladkiy-zheltyy'));
        $finder = new \DOMXPath($dom);
        $nodes = $finder->query('//div[@class="plain-text"]/div[@class="field-row"]');
        if ($nodes->length > 2) {
            foreach ($nodes as $key => $node) {
                if ($key == 2) {
                    $description = $node->nodeValue;
                }
            }
        }
        return $description;
    }

    public function convertAction()
    {
        $ingredients = Ingredient::find();
        foreach ($ingredients as $ingredient) {
            $ingredient->setUnitAvailable(unserialize($ingredient->getUnitAvailable()));
            $ingredient->save();
        }
    }
}
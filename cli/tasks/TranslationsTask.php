<?php


namespace Tasks;


class TranslationsTask
{
    public $option = [];

    public function init()
    {

    }
    public function parseAction()
    {
        $dir = '/var/www/try_cook/app/frontend';
        $idir = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        $translations = [];
        foreach($idir as $file)
        {
            if ($file != '.' && $file != '..')
            {
                $extension = pathinfo($file)['extension'];
                if ($extension === 'volt'){
                    $translations = array_merge($this->process($file->__toString()),$translations);
                }
            }
        }
        $translations = array_unique($translations);
        echo '<pre>';
        var_dump($translations);
        die();
    }

    public function process($file)
    {
        $subject = file_get_contents($file);
        $currentTranslator = 't\._';//in view files
//        $currentTranslator = '\$this->t->_'; // in php files
        $pattern = '/\b.*?' . $currentTranslator . '\(\'(.+?)\'\)/';
        $countMatches = preg_match_all(
            $pattern,
            $subject,
            $matches,
            PREG_SET_ORDER
        );
        $translationPatterns = [];
        if ($countMatches) {
            foreach ($matches as $match) {
                $translationPatterns[] = $match[1];
                echo $match[1]."\n";
            }
        }
        return $translationPatterns;
    }
}
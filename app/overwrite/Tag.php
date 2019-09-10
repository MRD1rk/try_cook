<?php

namespace Overwrite;

use Models\Configuration;
use Models\OgTag;

class Tag extends BaseOverwrite
{
    public $og;
    protected $title;
    protected $title_prefix = false;
    protected $description;
    protected $apple_touch_icons = false;

    public function __construct()
    {
        parent::__construct();
        $this->og = new OgTag();
        $site_desc = Configuration::get('SITE_META_DESCRIPTION',true);
        $this->description = $site_desc;
    }

    public function setTitle($title_text)
    {
        $this->title = $title_text;

        if (!$this->og->title)
            $this->og->title = $title_text;
        return $this;
    }

    public function getTitle($tags = true)
    {
        $content = $this->title;
        if ($this->title) {
            $content .= $this->title_prefix;
        }

        if ($tags) {
            return '<title>' . $content . '</title>';
        }
        return $content;
    }

    public function appendTitle($prefix)
    {
        $this->title_prefix = $prefix;
        if ($this->og->title) {
            $og_title = $this->og->title;
            $this->og->title = $og_title . $prefix;
        }
    }

    public function setDescription($text)
    {
        $this->description = $text;
    }

    public function getDescription($html = true)
    {
        if (!isset($this->description))
            return '';
        if ($html) {
            return '<meta name="description" content="' . $this->description . '">';
        }
        return $this->description;
    }

    public function getAppleTouchIcons()
    {
        if($this->apple_touch_icons){
            return $this->apple_touch_icons;
        }
        $result = '';
        $icons_path = Configuration::get('APPLE_TOUCH_ICONS_PATH');
        $sizes = ['','76x76','120x120','152x152'];
        foreach ($sizes as $size) {
            if($size == ''){
                $result .= '<link rel="apple-touch-icon" href="'.$icons_path.'.png'.'">'.PHP_EOL;
                continue;
            }
            $result .= '<link rel="apple-touch-icon" sizes="'.$size.'" href="'.$icons_path.'-'.$size.'.png'.'">'.PHP_EOL;
        }
        $this->apple_touch_icons = $result;
        return $this->apple_touch_icons;
    }
}
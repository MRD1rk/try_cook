<?php

namespace Overwrite;

use Phalcon\Flash\Session;

class FlashSession extends Session
{
    public $closeButton = true;

    public function __construct($cssClasses = [])
    {
        if (empty($cssClassess)) {
            $cssClasses = [
                "error" => "alert alert-danger",
                "success" => "alert alert-success",
                "notice" => "alert alert-info",
                "warning" => "alert alert-warning",
            ];
        }
        $this->setCssClasses($cssClasses);
        parent::__construct();
    }


    /**
     * Overwrite output method
     * @param bool $remove
     * @return void
     */
    public function output(bool $remove = true) :void
    {
        $filter = new \Phalcon\Filter();
        $html = '';
        $flash_messages = $this->getMessages();
        if (!empty($flash_messages)) {
            foreach ($flash_messages as $type => $messages) {
                foreach ($messages as $message) {
                    $html = '<div class="alert-overwrite ' . $this->_cssClasses[$type] . '">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                '.$filter->sanitize($message,'string').'</div>';
                }
                $this->outputMessage($type, $html);
            }
        }
        parent::clear();
    }


}
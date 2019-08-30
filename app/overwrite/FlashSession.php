<?php

namespace Overwrite;

use Phalcon\Flash\Session;

class FlashSession extends Session
{
    public $closeButton = true;

    public function __construct($cssClassess = [])
    {
        if (empty($cssClassess)) {
            $cssClassess = [
                "error" => "alert alert-danger",
                "success" => "alert alert-success",
                "notice" => "alert alert-info",
                "warning" => "alert alert-warning",
            ];
        }
        parent::__construct($cssClassess);
    }


    /**
     * Overwrite output method
     * @param bool $remove
     * @return string|void
     */
    public function output($remove = true)
    {
        $filter = new \Phalcon\Filter();
        $html = '';
        $flash_messages = $this->getMessages();
        if (!empty($flash_messages)) {
            foreach ($flash_messages as $type => $messages) {
                foreach ($messages as $message) {
                    $html .= '<div class="' . $this->_cssClasses[$type] . '">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                '.$filter->sanitize($message,'string').'</div>';
                }
            }
        }
        return $html;
    }


}
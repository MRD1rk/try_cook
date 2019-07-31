<?php

namespace Modules\Frontend\Controllers;

use Models\Context;
use Phalcon\Mvc\Controller;

/**
 * @property Context context
 */
class ControllerBase extends Controller
{

    public function initialize()
    {
        $this->view->t = $this->getDI()->get('t');
        $this->view->iso_code = $this->context->getLang()->iso_code;
    }
}

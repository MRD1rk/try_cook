<?php

namespace Modules\Api\Controllers;

use Models\Context;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Context context
 */
class BaseController extends Controller
{

    public function initialize()
    {
    }
}

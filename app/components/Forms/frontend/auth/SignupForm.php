<?php

namespace Modules\Frontend\Forms;

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class SignupForm extends Form
{
    public function initialize()
    {
        $this->add(new Text(
            'firstname'
        ));
        $this->add(new Text(
            'lastname'
        ));
    }
}
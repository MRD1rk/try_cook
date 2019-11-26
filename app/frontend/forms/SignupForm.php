<?php

namespace Modules\Frontend\Forms;

use Components\CSRF;
use Models\Configuration;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SignupForm extends BaseForm
{
    public function initialize()
    {
        $password_min_length = Configuration::get('PASSWORD_MIN_LENGTH');
        $password_max_length = 16;
        $firstname = new Text(
            'firstname',
            [
                'min' => 3
            ]
        );
        $firstname->setLabel($this->t->_('firstname'));
        $firstname->addValidator(
            new StringLength(
                [
                    'min' => 3,
                    'messageMinimum' => 'firstname_is_too_short'
                ]
            )
        );
        $firstname->addValidator(
            new PresenceOf([
                    'message' => 'firstname_is_required'
                ]
            )
        );
        $this->add($firstname);
        $lastname = new Text('lastname', [
                'min' => 3
            ]
        );
        $lastname->setLabel($this->t->_('lastname'));
        $lastname->addValidator(
            new StringLength(
                [
                    'min' => 3,
                    'messageMinimum' => 'lastname_is_too_short'
                ]
            )
        );
        $lastname->addValidator(
            new PresenceOf(
                [
                    'message' => 'lastname_is_required'
                ]
            )
        );
        $this->add($lastname);
        $email = new Email('email');
        $email->addValidator(new \Phalcon\Validation\Validator\Email(
            [
                'message' => 'incorrect_email'
            ]
        ));
        $this->add($email);

        $password = new Password('password',
            [
                'min' => $password_min_length,
                'helper' => $this->t->_('password_must_be_longed_message')
            ]);
        $password->setLabel('password');
        $password->addValidator(new Confirmation([
            'with' => 'confirm_password',
            'message' => 'password_does_not_match_confirmation'
        ]));
        $password->addValidator(
            new StringLength(
                [
                    'min' => $password_min_length,
                    'messageMinimum' => 'password_min_length_' . $password_min_length
                ]
            )
        );
        $password->addValidator(
            new Callback([
                'callback' => function ($password) use ($password_min_length, $password_max_length) {
                    $pattern = '/^\S*(?=\S{' . $password_min_length . ',' . $password_max_length . '})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
                    $valid = preg_match($pattern, $password);
                    return $valid;
                },
                'message' => 'password_must_be_longed_message'
            ])
        );
        $this->add($password);
        $confirm_password = new Password('confirm_password',
            [
                'min' => $password_min_length
            ]);
        $confirm_password->setLabel('confirm_password');
        $confirm_password->addValidator(new Confirmation([
            'with' => 'password',
            'message' => 'password_does_not_match_confirmation'
        ]));
        $confirm_password->addValidator(
            new StringLength(
                [
                    'min' => $password_min_length,
                    'messageMinimum' => 'password_min_length_' . $password_min_length
                ]
            )
        );
        $this->add($confirm_password);
        $csrf = new CSRF();
        $this->add((new Hidden($csrf->getTokenKey()))->setDefault($csrf->getToken()));
    }

    public function renderCsrf()
    {
        return $this->render((new CSRF())->getTokenKey());
    }

    public function renderDecorated($name, $helper = '')
    {
        $element = $this->get($name);
        $messages = $this->getMessagesFor($element->getName());

        $errors = '';
        if (count($messages)) {
            $valid_class = 'is-invalid';
            foreach ($messages as $message) {
                $errors .= '<div class="invalid-feedback">' . $this->t->_($message->getMessage()) . '</div>';
            }
        } else {
            $valid_class = '';
        }
        $html = '<div class="form-group">';
        $html .= '<label for="' . $element->getName() . '">' . $element->getLabel() . '</label>';
        $html .= $element->render(['class' => 'form-control ' . $valid_class]);
        $html .= '<small>' . $element->getAttribute('helper') . '</small>';
        $html .= $errors;
        $html .= '</div>';
        return $html;
    }
}
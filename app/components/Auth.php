<?php


namespace Components;


use MicheleAngioni\PhalconAuth\Exceptions\WrongCredentialsException;
use Phalcon\Mvc\User\Component;

class Auth extends Component
{

    protected $entity;
    protected $options;

    public function __construct($entity, $options = [])
    {
        $this->entity = $entity;
        $this->options = $options;
    }

    public function login($email, $password, $remember_me, $save_session)
    {
        $entity = $this->entity->findFirstByEmail($email);
        if (!$entity) {
            throw new \Exception('Wrong email/password combination');
        }
        if (!$entity->active)
            throw new \Exception('User banned');
        if (!$this->security->checkHash($password, $entity->password))
            throw new \Exception('User banned');

        if ($remember_me) {
            $this->saveSessionData($entity);

            // Check if the remember me was selected
            if ($save_session) {
                $this->createRememberEnvironment($entity);
            }
        }

        return $entity;
    }


    public function saveSessionData($entity)
    {
        $path = explode('\\', get_class($entity));
        $session_name = strtolower(array_pop($path));
        $session_name = $session_name.'_data';
        $this->session->set($session_name,[
            'id' => $entity->getId(),
            'name' => $entity->getFullName()
        ]);
    }

    public function createRememberEnvironment($entity)
    {
        $userAgent = $this->request->getUserAgent();
    }
}
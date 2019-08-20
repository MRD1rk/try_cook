<?php


namespace Components;


use MicheleAngioni\PhalconAuth\Exceptions\WrongCredentialsException;
use Models\Configuration;
use Models\TokenStorage;
use Phalcon\Mvc\User\Component;
use Phalcon\Security;

class Auth extends Component
{

    protected $entity;
    protected $options;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string|null
     */
    protected $token_cookie_name;
    /**
     * @var string|null
     */
    protected $series_cookie_name;

    public function __construct($entity, $options = [])
    {
        $this->token_cookie_name = Configuration::get('TOKEN_COOKIE_NAME');
        $this->series_cookie_name = Configuration::get('SERIES_COOKIE_NAME');
        $this->entity = $entity;
        $this->options = $options;
        $path = explode('\\', get_class($entity));
        $this->type = strtolower(array_pop($path));
    }

    public function login($email, $password, $remember_me = false, $save_session = true)
    {
        $entityClass = get_class($this->entity);
        $entity = $entityClass::findFirstByEmail($email);
        if (!$entity) {
            throw new \Exception('Wrong email/password combination');
        }
        if (!$entity->active)
            throw new \Exception('User banned');
        if (!$this->security->checkHash($password, $entity->password))
            throw new \Exception('Wrong email/password combination ');

        if ($remember_me) {
            $this->saveSessionData($entity);

            // Check if the remember me was selected
            if ($save_session) {
                $this->createRememberEnvironment();
            }
        }

        return true;
    }

    public function persistentLogin()
    {
        if (!$this->hasRememberMe()) {
            $this->remove();
            return false;
        }

        $seriesCookies = $this->cookies->get($this->series_cookie_name);
        $series = $seriesCookies->getValue();
        $tokenCookies = $this->cookies->get($this->token_cookie_name);
        $token = $tokenCookies->getValue();
        $tokenStorage = TokenStorage::findFirst(['conditions' => 'type="' . $this->type . '" AND  series="' . $series . '" and expires >=' . time()]);
        if (!$tokenStorage && $tokenStorage->getToken() !== $token) {
            $this->remove();
            return false;
        }
        $entityClass = get_class($this->entity);
        $entity = $entityClass::findFirstById($tokenStorage->getId());
        if (!$entity->active) {
            $this->remove();
            return false;
        }
        $tokenStorage->refreshToken();
        $expires = $tokenStorage->getExpires();
        $this->cookies->set($this->token_cookie_name, $tokenStorage->getToken(), $expires);
        $this->cookies->set($this->series_cookie_name, $tokenStorage->getSeries(), time() + TokenStorage::SERIES_EXPIRES);
        $this->cookies->send();
        return true;
    }

    public function hasRememberMe()
    {
        return $this->cookies->has($this->token_cookie_name) && $this->cookies->has($this->series_cookie_name);
    }

    public function saveSessionData($entity)
    {

        $session_name = $this->type . '_data';
        $this->session->set($session_name, [
            'id' => $entity->getId(),
            'name' => $entity->getFullName()
        ]);
    }

    public function createRememberEnvironment()
    {
        $tokenStorage = new TokenStorage();
        $tokenStorage->setId($this->entity->getId());
        $tokenStorage->setIp($this->request->getClientAddress());
        $tokenStorage->setType($this->type);
        $tokenStorage->save();
        $expires = $tokenStorage->getExpires();
        $this->cookies->set($this->token_cookie_name, $tokenStorage->getToken(), $expires);
        $this->cookies->set($this->series_cookie_name, $tokenStorage->getSeries(), time() + TokenStorage::SERIES_EXPIRES);
        $this->cookies->send();

    }


    /**
     * Removes the entity identity information from remember me cookies and session.
     */
    protected function remove()
    {
        // Destroy the remember me environment

        if ($this->cookies->has($this->token_cookie_name)) {
            $this->cookies->get($this->token_cookie_name)->delete();
        }

        if ($this->cookies->has($this->series_cookie_name)) {
            $this->cookies->get($this->series_cookie_name)->delete();
        }

        // Logout the entity
        $this->logout();
    }


    /**
     * Logout the entity, i.e. removes the session data but keeps the remember me environment.
     */
    public function logout()
    {
        $session_name = $this->type . '_data';
        $this->session->remove($session_name);
    }
}
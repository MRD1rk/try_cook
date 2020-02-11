<?php


namespace Components;


use Phalcon\Http\Response;
use Phalcon\Mvc\User\Component;
use Phalcon\Events\Event;
use \Phalcon\Mvc\Dispatcher;

class CSRF extends Component
{
    protected $trusted = [];

    /**
     * Make sure any POST requests contain a valid CSRF key & token
     *
     * This method called by the Dispatcher's Event manager because this component
     * was added as a dispatch listener in bootstrap.php.
     *
     * Forwards (not redirect) to index/csrf if the token wasn't set.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher The Event Dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        if (!$this->tokenExist())
            $this->generateToken();
        # Handle CSRF check
        if ($dispatcher->getControllerName() != 'error' && $dispatcher->getActionName() != 'csrf') {
            if ($this->request->isPost()) {
                if (!$this->checkToken($this->request->isAjax())) {
                    if ($this->request->isAjax()) {
                        $response = new Response();
                        $response->setStatusCode(400);
                        $response->setJsonContent(['status' => false, 'message' => 'CSRF is not valid']);
                        $response->send();
                        exit();
                    } else {
                        $dispatcher->forward(['controller' => 'errors', 'action' => 'csrf']);
                    }
                }
            }
        }
    }

    /**
     * Get the CSRF token key
     *
     * Generates the key & token if key wasn't already set
     *
     * @return string The token key
     * @see  self::generateToken()
     *
     */
    public function getTokenKey(): string
    {
        if (!$this->session->get('csrf_token_key'))
            $this->generateToken();

        return $this->session->get('csrf_token_key');
    }

    /**
     * Get the CSRF token
     *
     * Generates the key & token if token wasn't already set
     *
     * @return string The token
     * @see  self::generateToken()
     *
     */
    public function getToken(): string
    {
        if (!$this->session->get('csrf_token'))
            $this->generateToken();

        return $this->session->get('csrf_token');
    }

    /**
     * Checks $_POST to ensure the proper token key & token were POSTed
     *
     * @param bool $ajax
     * @return boolean whether or not the appropriate values were found it $_POST
     */
    public function checkToken($ajax = true): bool
    {
        $stored_key = $this->getTokenKey();
        $stored_token = $this->getToken();
        $passed_token = $ajax ?
            $this->request->getHeader('X-CSRF-TOKEN-KEY') . $this->request->getHeader('X-CSRF-TOKEN-VALUE') :
            $this->getTokenKey() . $this->request->get($this->getTokenKey());

        if ($stored_key . $stored_token !== $passed_token)
            return false;
        return true;
    }

    /**
     * Generates the token & key and stores them in session
     */
    public function generateToken()
    {
        $this->session->set('csrf_token_key', $this->security->getTokenKey());
        $this->session->set('csrf_token', $this->security->getToken());
    }

    public function tokenExist()
    {
        return $this->session->has('csrf_token');

    }

    /**
     * @param $resource string|array of route alias
     * @return $this
     */
    public function push($resource)
    {
        if (is_array($resource))
            $this->trusted = array_merge($this->trusted, $resource);
        else
            $this->trusted[] = $resource;
        return $this;
    }

}
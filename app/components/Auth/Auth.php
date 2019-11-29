<?php


namespace Components\Auth;


use Models\Context;
use Models\FailedLogins;
use Models\SuccessLogins;
use Models\TokenStorage;
use Models\User;
use Phalcon\Mvc\User\Component;

class Auth extends Component
{
    /**
     * @var integer
     */
    protected $expire;

    public function __construct($expire)
    {
        $this->expire = $expire;
    }

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolean
     * @throws \Exception
     */
    public function check($credentials)
    {
        // Check if the user exist
        $user = User::findFirstByEmail($credentials['email']);
        if (!$user) {
            $this->registerUserThrottling(0);
            throw new \Exception('wrong_email_password_combination');
        }
        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->password)) {
            $this->registerUserThrottling($user->getId());
            throw new \Exception('wrong_email_password_combination');
        }
        // Check if the user was flagged
        $this->checkUserFlags($user);
        // Register the successful login
        $this->saveSuccessLogin($user);
        // Check if the remember me was selected
        if (!empty($credentials['remember_me'])) {
            $this->createRememberEnvironment($user);
        }
        $user->setLogged(1);
        $user->setLastLogin(date('Y-m-d H:i:s'));
        $user->save();
        Context::getInstance()->setUser($user);
        $this->session->set('auth-identity', [
            'id' => $user->getId(),
            'id_role' => $user->getIdRole(),
            'name' => $user->getFullName(),
        ]);
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param User $user
     * @throws \Exception
     */
    public function saveSuccessLogin($user)
    {
        $successLogin = new SuccessLogins();
        $successLogin->setIdUser($user->getId());
        $successLogin->setIp($this->request->getClientAddress());
        $successLogin->setUserAgent($this->request->getUserAgent());
        if (!$successLogin->save()) {
            $messages = $successLogin->getMessages();
            throw new \Exception($messages[0]->getMessage());
        }
    }

    /**
     * Implements login throttling
     * Reduces the effectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId)
    {
        $failedLogin = new FailedLogins();
        $failedLogin->setIdUser($userId);
        $failedLogin->setIp($this->request->getClientAddress());
        $failedLogin->setAttempted(time());
        $failedLogin->save();
        $attempts = FailedLogins::count([
            'ip = ?0 AND attempted >= ?1',
            'bind' => [
                $this->request->getClientAddress(),
                time() - 3600 * 6
            ]
        ]);
        /*switch ($attempts) {
            case 1:
            case 2:
                // no delay
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            case 10:
            default:
                sleep($attempts);
                break;
        }
        */
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     * @param User $user
     */
    public function createRememberEnvironment(User $user)
    {
        $userAgent = $this->request->getUserAgent();
        $token = md5($user->getEmail() . $user->getPassword() . $userAgent);
        $remember = new TokenStorage();
        $remember->setIdUser($user->getId());
        $remember->setIp($this->request->getClientAddress());
        $remember->setToken($token);
        $remember->setUserAgent($userAgent);
        if ($remember->save() != false) {
            $expire = time() + $this->expire;
            $this->cookies->set('RMU', $user->getId(), $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the cookies
     *
     * @return \Phalcon\Http\Response
     * @throws \Exception
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();
        $user = User::findFirst($userId);
        if ($user) {
            $userAgent = $this->request->getUserAgent();
            $token = md5($user->getEmail() . $user->getPassword() . $userAgent);
            if ($cookieToken == $token) {
                $remember = TokenStorage::findFirst([
                    'id_user = ?0 AND token = ?1',
                    'bind' => [
                        $user->getId(),
                        $token
                    ]
                ]);
                if ($remember) {
                    // Check if the cookie has not expired
                    if ((time() - ($this->expire)) < strtotime($remember->getDateAdd())) {
                        // Check if the user was flagged
                        $this->checkUserFlags($user);
                        // Register identity
                        $this->session->set('auth-identity', [
                            'id' => $user->getId(),
                            'name' => $user->getFullName()
                        ]);
                        // Register the successful login
                        $this->saveSuccessLogin($user);
                        return $this->response->redirect($this->url->get('/'));
                    }
                }
            }
        }
        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();
        return $this->response->redirect($this->url->get('/'));
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param User $user
     * @throws \Exception
     */
    public function checkUserFlags(User $user)
    {
        if (!$user->getActive()) {
            throw new \Exception('the_user_is_not_active');
        }
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['name'];
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $token = $this->cookies->get('RMT')->getValue();
            $userId = $this->findFirstByToken($token);
            if ($userId) {
                $this->deleteToken($userId);
            }

            $this->cookies->get('RMT')->delete();
        }
        $this->session->remove('auth-identity');
    }

    /**
     * Auths the user by his/her id
     *
     * @param int $id
     * @throws \Exception
     */
    public function authUserById($id)
    {
        $user = User::findFirst($id);
        if ($user == false) {
            throw new \Exception('The user does not exist');
        }
        $this->checkUserFlags($user);
        $this->session->set('auth-identity', [
            'id' => $user->getId(),
            'name' => $user->getFullName()
        ]);
    }

    /**
     * Get the entity related to user in the active identity
     *
     * @throws \Exception
     */
    public function getUser()
    {
        $identity = $this->session->get('auth-identity');
        if (isset($identity['id'])) {
            $user = User::findFirstById($identity['id']);
            if ($user == false) {
                throw new \Exception('The user does not exist');
            }
            return $user;
        }
        return false;
    }

    /**
     * Returns the current token user
     *
     * @param string $token
     * @return boolean|User
     */
    public function findFirstByToken($token)
    {
        $userToken = TokenStorage::findFirst([
            'conditions' => 'token = :token:',
            'bind' => [
                'token' => $token,
            ],
        ]);

        $user_id = ($userToken) ? $userToken->getIdUser() : false;
        return $user_id;
    }

    /**
     * Delete the current user token in session
     * @param integer $id_user
     */
    public function deleteToken($id_user)
    {
        $user = TokenStorage::find([
            'conditions' => 'id_user = :id_user:',
            'bind' => [
                'id_user' => $id_user
            ]
        ]);
        if ($user) {
            $user->delete();
        }
    }
}
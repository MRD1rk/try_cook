<?php


namespace Modules\Backend\Plugins;


use Models\Configuration;
use Models\Context;
use Models\TokenStorage;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

class PersistentLoginPlugin extends Plugin
{
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        if (Context::getInstance()->getEmployee()->logged)
            $this->checkStorage();
    }

    public function checkStorage()
    {
        $cookies = $this->cookies;
        $token_cookie_name = Configuration::get('TOKEN_COOKIE_NAME');
        $series_cookie_name = Configuration::get('SERIES_COOKIE_NAME');
        $type = 'employee';
        $series = $cookies->get($series_cookie_name)->getValue();
        $token = $cookies->get($token_cookie_name)->getValue();
        $ip = $_SERVER['REMOTE_ADDR'];
        $storage = TokenStorage::findFirst(['conditions' => 'type="' . $type . '" AND  series="' . $series . '" and expires >=' . time()]);
        if ($storage && $storage->getToken() === $token) {
            $storage->refreshToken();
        } else {
            $storage = new TokenStorage();
            $storage->setId(Context::getInstance()->getEmployee()->getId());
            $storage->setIp($ip);
            $storage->setType($type);
            $storage->save();
        }
        $expires = $storage->getExpires();
        $cookies->set($token_cookie_name, $storage->getToken(), $expires);
        $cookies->set($series_cookie_name, $storage->getSeries(), time() + TokenStorage::SERIES_EXPIRES);
        $cookies->send();

    }
}
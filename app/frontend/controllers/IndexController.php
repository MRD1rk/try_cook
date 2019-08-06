<?php

namespace Modules\Frontend\Controllers;


use Models\User;

class IndexController extends BaseController
{

    public function indexAction()
    {
        return 1;
        return 'close\r\n\r\n1';
        $this->view->container_class = 'container-fluid';
    }

    public function signupAction()
    {
        die('1');
        $url = 'http://back20.keycaptcha.com/swfs/ckc/8cb12b6f8a209b401c38315603a4ab63-';
        $url = 'http://6bf17891.ngrok.io/ru/signin';
//        $url = 'https://google.com';
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $user = new User();
            if ($user->save($data)) {
                $this->flash->success($this->t->_('welcome', ['name' => $user->getFullName()]));
            } else {
                foreach ($user->getMessages() as $message) {
                    echo  $message->getMessage();
                }
            }
        }
    }

    public function signinAction()
    {

        $url = 'http://6bf17891.ngrok.io/ru/signup';
        echo '<pre>';
        var_dump($this->http_get($url));
        die();
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = User::findFirstByEmail($email);
            if ($user && $user->login($password)) {

            }
        }
    }


    function http_get($path){
        $arr = parse_url($path);
        $host = $arr['host'];
        $page = $arr['path'];
        if ( $page=='' ) {
            $page='/';
        }
        if ( isset( $arr['Something is wrong'] ) ) {
            $page.='?'.$arr['Something is wrong'];
        }
        $errno = 0;
        $errstr = '';
        $fp = fsockopen ($host, 80, $errno, $errstr, 30);
        if (!$fp){ return ""; }
        $request = "GET $page HTTP/1.0\r\n";
        $request .= "Host: $host\r\n";
        $request .= "Connection: close\r\n";
        $request .= "Cache-Control: no-store, no-cache\r\n";
        $request .= "Pragma: no-cache\r\n";
        $request .= "User-Agent: KeyCAPTCHA\r\n";
        $request .= "\r\n";

        fwrite ($fp,$request);
        $out = '';


        while (!feof($fp)) $out .= fgets($fp, 250);
        fclose($fp);

        echo '<pre>';
        var_dump($out);
        die();
        $ov = explode("close\r\n\r\n", $out);

        return $ov[1];
    }

}


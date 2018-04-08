<?php

namespace Admin\Controllers;

class IndexController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	var_dump(class_exists('\Phalcon\Chart\QRcode'), 'aaaaaaaaaa');
    }

    /**
     * 用户登录
     * @return 
     */
    public function loginAction()
    {
        if($this->request->isPost())
        {
            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");
            //var_dump($email, $password);

        }

        //print_r(\Service\Wechat\Common\Utils::getConfig());

    }

    public function paramsAction()
    {

    }
}

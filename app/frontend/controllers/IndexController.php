<?php

namespace Frontend\Controllers;

//use Endroid\QrCode\QrCode;

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->view->layout = 'layouts/main.volt';
    }

    public function route404Action()
    {
        die('404');
    }
}


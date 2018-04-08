<?php

namespace Frontend\Controllers;

use Endroid\QrCode\QrCode;

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        die('index/index');
    }

    public function route404Action()
    {
        die('404');
    }
}


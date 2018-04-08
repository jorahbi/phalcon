<?php

namespace Admin\Controllers;

class AdminController extends \Phalcon\Mvc\Controller
{
    public function loginAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
}

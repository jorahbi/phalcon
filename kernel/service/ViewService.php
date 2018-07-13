<?php


namespace Kernel\service;

use Phalcon\Mvc\View;


class ViewService extends View implements ServiceInterface
{
    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}
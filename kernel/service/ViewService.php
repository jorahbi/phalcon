<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/15
 * Time: 下午9:13
 */

namespace Kernel\service;

use Phalcon\Mvc\View;


class ViewService extends View implements ServiceInterface
{
    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}
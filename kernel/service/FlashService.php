<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/15
 * Time: 下午9:15
 */

namespace Kernel\service;

use Phalcon\Flash\Direct;


class FlashService extends Direct implements ServiceInterface
{
    public function __construct($cssClasses = null)
    {
        new self([
            'error' => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
            'warning' => 'alert alert-warning',
        ]);
    }
}
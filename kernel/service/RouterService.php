<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/15
 * Time: 下午9:14
 */

namespace Kernel\service;

use Phalcon\Mvc\Router;

class RouterService extends Router implements ServiceInterface
{
    public function __construct($defaultRoutes = null)
    {
        parent::__construct($defaultRoutes);
        $this->setUriSource(RouterService::URI_SOURCE_SERVER_REQUEST_URI);
        $this->removeExtraSlashes(true);
    }
}
<?php

namespace Kernel;

use Phalcon\Config\Adapter\Php as ConfigPhp;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

class Routers
{
    private static $routerGroup = [];
    protected static $routerMap = [];

    public static function initialize()
    {
        $router          = Service::getService('router');
        self::$routerMap = new ConfigPhp(BASE_PATH . '/common/config/router.php');
        foreach (self::$routerMap->group as $key => $value) {
            $routerGroup = new RouterGroup([
                'module'    => $value->module,
                'namespace' => $value->namespace,
            ]);
            $routerGroup->setPrefix($key);
            $routerGroup->add('/:controller', [
                'controller' => 1,
                'action'     => 'index',
            ]);
            $routerGroup->add('/:controller/:action/:params', [
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
            ]);
            self::$routerGroup[$key] = $routerGroup;
            $router->mount($routerGroup);
        }

        $router->add('/', [
            'module'     => self::$routerMap->default->module,
            'namespace'  => self::$routerMap->default->namespace,
            'controller' => self::$routerMap->default->controller,
            'action'     => self::$routerMap->default->action,
        ]);
        $router->notFound([
            'module'     => self::$routerMap->notFound->module,
            'namespace'  => self::$routerMap->notFound->namespace,
            'controller' => self::$routerMap->notFound->controller,
            'action'     => self::$routerMap->notFound->action,
        ]);
        self::other($router);
    }

    /**
     * 特殊的路由配置
     */
    public static function other(Router $router)
    {
        foreach (self::$routerMap->other as $value) {
            if (isset($value->group) && !empty($value->group)) {
                self::$routerGroup[$value->group]->add($value->url, [
                    'controller' => $value->controller,
                    'action'     => $value->action,
                ]);
                $router->mount(self::$routerGroup[$value->group]);
                continue;
            }
            $router->add($value->url,
                [
                    'controller' => $value->controller,
                    'action'     => $value->action,
                ]
            );
        }
    }

    public static function getRouterMap()
    {
        return self::$routerMap;
    }
}

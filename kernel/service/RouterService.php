<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/15
 * Time: 下午9:14
 */

namespace Kernel\service;

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group;

class RouterService extends Router implements ServiceInterface
{
    private $config;

    public function __construct(ConfigService $config, $defaultRoutes = null)
    {
        $this->config = $config;
        parent::__construct($defaultRoutes);
        $this->setUriSource(RouterService::URI_SOURCE_SERVER_REQUEST_URI);
        $this->removeExtraSlashes(true);
    }

    /**
     *
     */
    public function init()
    {
        $routerMap = $this->config->getRouter();
        $routerGroups = [];
        foreach ($routerMap->group as $key => $value) {
            $group = new Group([
                'module'    => $value->module,
                'namespace' => $value->namespace,
            ]);
            $group->setPrefix($key);
            $group->add('/:controller', [
                'controller' => 1,
                'action'     => 'index',
            ]);
            $group->add('/:controller/:action/:params', [
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
            ]);
            $routerGroups[$key] = $group;
            $this->mount($group);
        }

        $this->add('/', [
            'module'     => $routerMap->default->module,
            'namespace'  => $routerMap->default->namespace,
            'controller' => $routerMap->default->controller,
            'action'     => $routerMap->default->action,
        ]);
        $this->notFound([
            'module'     => $routerMap->notFound->module,
            'namespace'  => $routerMap->notFound->namespace,
            'controller' => $routerMap->notFound->controller,
            'action'     => $routerMap->notFound->action,
        ]);
        $this->other($routerGroups);
    }

    /**
     * 特殊的路由配置
     */
    private function other(Array $routerGroups)
    {
        foreach ($this->config->getRouter()->other as $value) {
            if (isset($value->group) && !empty($value->group)) {
                call_user_func_array([$routerGroups[$value->group], 'add'], [
                    $value->url, [
                        'controller' => $value->controller,
                        'action'     => $value->action,
                    ]
                ]);
                $this->mount($routerGroups[$value->group]);
                continue;
            }
            $this->add($value->url,
                [
                    'controller' => $value->controller,
                    'action'     => $value->action,
                ]
            );
        }
    }
}
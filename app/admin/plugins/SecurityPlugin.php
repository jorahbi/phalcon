<?php

namespace Admin\Plugins;

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data;

class SecurityPlugin extends Plugin
{
	protected $acl = null;
	protected $config = null;

	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
    	$this->config = $this->getDI()->get('config')->getConfig();

    	$loginController = $this->config->security->loginController;
    	$loginAction = $this->config->security->loginAction;
    	 // 从分发器获取活动的 controller/action
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();
    	if($loginController == $controller && $loginAction == $action)
    	{
    		return null;
    	}

    	$this->getAcl();
    	
        $role = 'manager';
    	 // 检验角色是否允许访问控制器 (resource)
    	if (!$this->acl->isAllowed($role, $controller, $action)) {
            // 如果没有访问权限则转发到 index 控制器
            $this->flash->error('You don\'t have access to this module');

            $dispatcher->forward([
                'controller' => $this->config->security->loginController,
                'action'     => $this->config->security->loginAction,
            ]);

            // 返回 "false" 我们将告诉分发器停止当前操作
            return false;
        }
    }

    protected function getAcl()
    {
    	$this->acl = new AclList();
		// 默认行为是 DENY(拒绝) 访问
		$this->acl->setDefaultAction(Acl::DENY);
		$this->acl->addRole(new Role('manager'));
		$privateResources = $this->getRole();
		
		foreach ($privateResources as $resourceName => &$actions) {
		    $this->acl->addResource(new Resource($resourceName), $actions);
		     foreach ($actions as &$action) {
		        $this->acl->allow("manager", $resourceName, $action);
		    }
		}
		return $this->acl;
    }

    protected function getRole()
    {
        $cache = $this->getDI()->get('fileCache');
    	/*$cache = new BackFile(
    		new Data(), 
    		['cacheDir' => $this->config->cache->fileDir]
    	);*/
    	//var_dump($cache->queryKeys("admin-admin"));die;

    	if($cache->exists('admin.role.cache'))
    	{
    		return $cache->get('admin.role.cache');
    	}
    	$permission = \Admin\Models\Permission::find([
    		'id = :adminId:',
    		'bind' => ['adminId' => 2],
    		'cache' => ['key' => 'admin-admin-premission.cache']
    	]);
    	$roles = [];
    	foreach ($permission as $key => $value) 
    	{
    		if(!$value->controller && !$value->action)
    			continue;
    		$roles[$value->controller][] = $value->action;
    	}
    	$config = $this->getDI()->get('config')->getConfig();
        if (!is_dir($config->application->runtime . $config->cache->cacheDir)) {
            @mkdir($config->application->runtime . $config->cache->cacheDir , 0755, true);
        }
    	$cache->save($config->cache->runtime . 'admin.role.cache', $roles);
    	return $roles;
    }
}
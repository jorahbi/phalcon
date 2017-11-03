<?php

namespace Common;

use Phalcon\Mvc\Router;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Router\Group as RouterGroup;

class Routers
{
	private static $routerGroup = [];

	public static function initialize()
	{
		$router = Service::getContainer()->getRouter();
		$config = Service::getContainer()->getConfig()->application;
		self::ordinary($router);
		self::special($router);
		$router->add('/', [
			'module' => $config->defaultModule,
    		'namespace' => $config->defaultNamespace,
    		'controller' => $config->defaultController,
    		'action' => $config->defaultAction
		]);
		$router->notFound([
			'module' => 'frontend',
    		'namespace' => 'Frontend\\Controllers',
	        'controller' => 'index',
	        'action'     => 'route404',
		]);
	}

	/**
	 * 特殊的路由配置
	 */
	public static function special(Router $router)
	{
		/*self::$routerGroup['/admin']->add('/test/{id}', [
			'controller' => 'index',
			'action' => 'params',
		]);*/
		//$router->mount(self::$routerGroup['/admin']);
	}

	/**
	 * 路由普通
	 */
	public static function ordinary(Router $router)
	{
		self::$routerGroup = [
			'' => new RouterGroup([
		        'module' => 'frontend',
    			'namespace' => 'Frontend\\Controllers',
			]),
			'/admin' => new RouterGroup([
		        'module' => 'admin',
		        'namespace' => 'Admin\\Controllers',
			]),
			'/passport' => new RouterGroup([
		        'module' => 'passport',
		        'namespace' => 'Passport\\Controllers',
			]),
		];

		foreach (self::$routerGroup as $key => &$value) 
		{
			$value->setPrefix($key);
			$value->add('/:controller', [
		        'controller' => 1,
		        'action' => 'index',
			]);
			$value->add('/:controller/:action/:params', [
		        'controller' => 1,
		        'action' => 2,
		        'params' => 3
			]);
			$router->mount($value);
		}
	}
}
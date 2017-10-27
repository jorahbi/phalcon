<?php

namespace Core;

use Phalcon\Mvc\Router;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Router\Group as RouterGroup;

class Routers
{
	private static $routerGroup = [];

	public static function initialize(Router $diRouter)
	{
		self::ordinary($diRouter);
		self::special($diRouter);
		/*$diRouter->notFound([
	        "controller" => "index",
	        "action"     => "route404",
		]);*/
	}

	/**
	 * 特殊的路由配置
	 */
	public static function special(Router $diRouter)
	{
		/*self::$routerGroup['/admin']->add('/test/{id}', [
			'controller' => 'index',
			'action' => 'params',
		]);*/
		//$diRouter->mount(self::$routerGroup['/admin']);
	}

	/**
	 * 路由普通
	 */
	public static function ordinary(Router $diRouter)
	{
		self::$routerGroup = [
			'/' => new RouterGroup([
		        'module' => 'frontend',
    			'namespace' => 'Frontend\\Controllers',
			]),
			'/admin' => new RouterGroup([
		        'module' => 'admin',
		        'namespace' => 'Admin\\Controllers',
			]),
			'/passport' => new RouterGroup([
		        'module' => 'admin',
		        'namespace' => 'Admin\\Controllers',
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
			$diRouter->mount($value);
		}
	}
}
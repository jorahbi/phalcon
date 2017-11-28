<?php

namespace Common;

use Phalcon\Mvc\Application;

class Loader
{

	public static function initialize(\Phalcon\Loader $loader)
	{
		/**
		 * Register Namespaces
		 */
		$namespace = [
		    'Common' => APP_PATH . '/common',
		    
		    'Service\\Wechat\\User' => APP_PATH . '/service/wechat/user',
		    'Service\\Wechat\\Message' => APP_PATH . '/service/wechat/message',
		    'Service\\Wechat\\Common' => APP_PATH . '/service/wechat/common',
		    'Service\\Wechat' => APP_PATH . '/service/wechat',

		    'Service\\Swoole\\Server' => APP_PATH . '/service/swoole/server',
		    'Service\\Swoole\\Task' => APP_PATH . '/service/swoole/task',
		    'Service\\Swoole\\Event' => APP_PATH . '/service/swoole/event',
		];

		$modules = self::getModules();
		foreach ($modules as $key => $value) 
		{
			$ucfirstKey = ucfirst($key);
			$namespace[$ucfirstKey . '\\Entity'] = MODULES_PATH . '/' . $key . '/entity';
			$namespace[$ucfirstKey . '\\Models'] = MODULES_PATH . '/' . $key . '/models';
			$namespace[$ucfirstKey . '\\Plugins'] = MODULES_PATH . '/' . $key . '/plugins';
			$namespace[$ucfirstKey . '\\Controllers'] = MODULES_PATH . '/' . $key . '/controllers';
		}

		$loader->registerNamespaces($namespace);

		/**
		 * Register module classes
		 */
		$loader->registerClasses([
		    'Frontend\\Module' => MODULES_PATH . '/frontend/Module.php',
		    'Admin\\Module' => MODULES_PATH . '/admin/Module.php',
		    'Product\\Module' => MODULES_PATH . '/product/Module.php',
		    'Passport\\Module' => MODULES_PATH . '/passport/Module.php',
		]);

		$loader->register();
	}

	/**
	 * 设置模块加载文件
	 */
	public static function getModules()
	{
		return [
	        'frontend' => [
	            'className' => 'Frontend\\Module',
	            'path' => APP_PATH . '/modules/frontend/Module.php'
	        ],
	        'admin' => [
	            'className' => 'Admin\\Module',
	            'path' => APP_PATH . '/modules/admin/Module.php'
	        ],
	        'passport' => [
	            'className' => 'Passport\\Module',
	            'path' => APP_PATH . '/modules/passport/Module.php'
	        ],
	    ];
	}
}
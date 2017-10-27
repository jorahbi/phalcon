<?php

namespace Core;

class Loader
{
	public static function initialize(\Phalcon\Loader $loader)
	{
		/**
		 * Register Files
		 */
		$loader->registerFiles([
			//APP_PATH . '/common/config/config.php'
		]);
		/**
		 * Register Namespaces
		 */
		$loader->registerNamespaces([
		    'Core' => APP_PATH . '/core',
		    'Common\\Config' => APP_PATH . '/common/config',
		    'Service\\Wechat\\User' => APP_PATH . '/service/wechat/user',
		    'Service\\Wechat\\Message' => APP_PATH . '/service/wechat/message',
		    'Service\\Wechat\\Common' => APP_PATH . '/service/wechat/common',
		    'Service\\Wechat' => APP_PATH . '/service/wechat',
		]);

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
}
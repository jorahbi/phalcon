<?php

namespace Core;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

class Bootstrap
{
	protected static $di = null;
	
	public static function run()
	{
		//try{
			self::$di = new FactoryDefault();
			Service::initialize(self::$di);
			Routers::initialize(self::$di->getRouter());
			
			$application = new Application(self::$di);

		    /**
		     * Register application modules
		     */
		    $application->registerModules([
		        'frontend' => [
		            'className' => 'Frontend\Module',
		            'path' => APP_PATH . '/modules/frontend/Module.php'
		        ],
		        'admin' => [
		            'className' => 'Admin\Module',
		            'path' => APP_PATH . '/modules/admin/Module.php'
		        ],
		    ]);
		    //debug
		    (new \Phalcon\Debug())->listen();
			$application->handle()->send();

		/*} catch (\Exception $e) {
			echo $e->getMessage() . '<br>';
			echo '<pre>' . $e->getTraceAsString() . '</pre>';
		}*/
	}

	private function __construct() {}
    private function __clone() {}
    private function __sleep() {}
    private function __wakeup() {} 
}
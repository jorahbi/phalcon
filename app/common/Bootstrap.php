<?php

namespace Common;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

class Bootstrap
{
	
	public static function run()
	{
		//try{
			//self::$container = Service::getContainer();
			
			Routers::initialize();
			$application = new Application(Service::getContainer());
			
		    /**
		     * Register application modules
		     */
		    $application->registerModules(Loader::getModules());

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
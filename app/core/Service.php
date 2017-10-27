<?php

namespace Core;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Config\Adapter\Php as ConfigPhp;

class Service
{
	protected static $container;

	/**
	 * 设置容器服务
	 * @param Phalcon\Di\FactoryDefault $container
	 */
	protected static function setContainer(FactoryDefault $container)
	{
		self::$container = $container;
	}

	/**
	 * 获取容器服务
	 * @return Phalcon\Di\FactoryDefault 
	 */
	public static function getContainer()
	{
		if(empty(self::$container))
		{
			self::initialize(new FactoryDefault());
		}
		return self::$container;
	}

	public static function initialize(FactoryDefault $container)
	{
		self::setContainer($container);
		/**
		 * Shared configuration service
		 */
		$container->setShared('config', function () {
			//\Common\Config\Configuration::CONFIG;
			return new ConfigPhp (APP_PATH . '/common/config/config.php');
		});

		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
		$container->setShared('db', function () {
		    $config = $this->getConfig();

		    $class = 'Phalcon\\Db\\Adapter\\Pdo\\' . $config->database->adapter;
		    $params = [
		        'host'     => $config->database->host,
		        'username' => $config->database->username,
		        'password' => $config->database->password,
		        'dbname'   => $config->database->dbname,
		        'charset'  => $config->database->charset
		    ];

		    if ($config->database->adapter == 'Postgresql') {
		        unset($params['charset']);
		    }

		    $connection = new $class($params);

		    return $connection;
		});

		/**
		 * If the configuration specify the use of metadata adapter use it or use memory otherwise
		 */
		$container->setShared('modelsMetadata', function () {
		    return new MetaDataAdapter();
		});

		/**
		 * Configure the Volt service for rendering .volt templates
		 */
		$container->setShared('voltShared', function ($view) {
		    $config = $this->getConfig();

		    $volt = new VoltEngine($view, $this);
		    $volt->setOptions([
		        'compiledPath' => function($templatePath) use ($config) {

		            $filename = md5($templatePath). '.php';
		            $cacheDir = $config->application->cacheDir;
		            if ($cacheDir && substr($cacheDir, 0, 2) == '..') {
		                $cacheDir = __DIR__ . DIRECTORY_SEPARATOR . $cacheDir;
		            }

		            $cacheDir = realpath($cacheDir);

		            if (!$cacheDir) {
		                $cacheDir = sys_get_temp_dir();
		            }

		            if (!is_dir($cacheDir . DIRECTORY_SEPARATOR . 'volt' )) {
		                @mkdir($cacheDir . DIRECTORY_SEPARATOR . 'volt' , 0755, true);
		            }

		            return $cacheDir . DIRECTORY_SEPARATOR . 'volt' . DIRECTORY_SEPARATOR . $filename;
		        }
		    ]);

		    return $volt;
		});

		/**
		 * Registering a router
		 */
		$container->setShared('router', function () {
			$config = $this->getConfig();
		    $router = new Router();
		    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI); 
		    $router->setDefaultModule($config->application->defaultModule);
		    $router->setDefaultNamespace($config->application->defaultNamespace);
			$router->setDefaultController($config->application->defaultController);
			$router->setDefaultAction($config->application->defaultAction);
		    $router->removeExtraSlashes(true);
		    return $router;
		});

		/**
		 * The URL component is used to generate all kinds of URLs in the application
		 */
		$container->setShared('url', function () {
		    $config = $this->getConfig();

		    $url = new UrlResolver();
		    $url->setBaseUri($config->application->baseUri);

		    return $url;
		});

		/**
		 * Starts the session the first time some component requests the session service
		 */
		$container->setShared('session', function () {
		    $session = new SessionAdapter();
		    $session->start();

		    return $session;
		});

		/**
		 * Register the session flash service with the Twitter Bootstrap classes
		 */
		$container->setShared('flash', function () {
		    return new Flash([
		        'error'   => 'alert alert-danger',
		        'success' => 'alert alert-success',
		        'notice'  => 'alert alert-info',
		        'warning' => 'alert alert-warning'
		    ]);
		});

		/**
		* Set the default namespace for dispatcher
		*/
		$container->setShared('dispatcher', function() {
		    $containerspatcher = new Dispatcher();
		    $containerspatcher->setDefaultNamespace('Frontend\\Controllers');
		    /*print_r(get_class_methods($this->getRouter()));
		    print_r($this->getRouter()->getModuleName());
		    print_r($this->getRouter()->getControllerName());
		    print_r($this->getRouter()->getActionName());
		    */
		    return $containerspatcher;
		});

		$container->set('modelsCache', function() {
			$config = $this->getConfig();
			if (!is_dir($config->cache->fileDir )) {
                @mkdir($config->cache->fileDir , 0755, true);
            }
			$cache = new BackFile(
	    		new Data(['lifetime' => $config->cache->lefttime]),
	    		['cacheDir' => $config->cache->modelDir]
	    	);
	    	return $cache;
		});

		$container->set('fileCache', function() {
			$config = $this->getConfig();
			if (!is_dir($config->application->cacheDir )) {
                @mkdir($config->application->cacheDir , 0755, true);
            }
			$cache = new BackFile(
	    		new Data(),
	    		['cacheDir' => $config->application->cacheDir]
	    	);
	    	return $cache;
		});

		/**
		 * 微信配置
		 */
		$container->setShared('wechatConfig', function(){
			return new ConfigPhp($this->getConfig()->thirdParty->wechatPath);
		});
	}
}
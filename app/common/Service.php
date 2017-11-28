<?php

namespace Common;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Crypt;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Config\Adapter\Php as ConfigPhp;
use Phalcon\Cache\Backend\Redis as RedisCache;

class Service
{
	protected static $container;

	/**
	 * 获取容器服务
	 * @return Phalcon\Di\FactoryDefault 
	 */
	public static function getContainer()
	{
		if(empty(self::$container))
		{
			var_dump("121212\n");
			self::$container = new FactoryDefault();
			self::initialize();
		}
		return self::$container;
	}

	public static function initialize()
	{
		/**
		 * Shared configuration service
		 */
		self::$container->setShared('config', function () {
			return new ConfigPhp (APP_PATH . '/common/config/config.php');
		});

		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
		self::$container->setShared('db', function () {
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
		self::$container->setShared('modelsMetadata', function () {
		    return new MetaDataAdapter();
		});

		/**
		 * Configure the Volt service for rendering .volt templates
		 */
		self::$container->setShared('voltShared', function ($view) {
		    $config = $this->getConfig();

		    $volt = new VoltEngine($view, $this);
		    $volt->setOptions([
		        'compiledPath' => function($templatePath) use ($config) {

		            $filename = md5($templatePath) . '.php';
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
		self::$container->setShared('router', function () {
			$config = $this->getConfig();
		    $router = new Router();
		    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI); 
		    $router->removeExtraSlashes(true);
		    return $router;
		});

		/**
		 * The URL component is used to generate all kinds of URLs in the application
		 */
		self::$container->setShared('url', function () {
		    $config = $this->getConfig();

		    $url = new UrlResolver();
		    $url->setBaseUri($config->application->baseUri);

		    return $url;
		});

		/**
		 * Starts the session the first time some component requests the session service
		 */
		self::$container->set('session', function () {
			$sessionConfig = $this->getConfig()->session;
			//new SessionAdapter()
			$sessionAdapter = $sessionConfig->adapter;
		    $session = new $sessionAdapter($sessionConfig->options->toArray());

		    $session->start();

		    return $session;
		}, true);

		/**
		 * cookie
		 */
		self::$container->setShared('cookies', function(){
			$cookies = new Cookies();
			$cookies->useEncryption($this->getConfig()->cookies->expire);
        	return $cookies;
		});

		/**
		 * Register the session flash service with the Twitter Bootstrap classes
		 */
		self::$container->setShared('flash', function () {
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
		self::$container->setShared('dispatcher', function() {
		    //$containerspatcher = new Dispatcher();
		    
		    return new Dispatcher();
		});

		self::$container->set('modelsCache', function() {
			$config = $this->getConfig()->cache->model;
			if (!is_dir($config->fileDir )) {
                @mkdir($config->fileDir , 0755, true);
            }
			return new BackFile(
	    		new Data(['lifetime' => $config->lefttime]),
	    		['cacheDir' => $config->modelDir]
	    	);
		});

		/**
		 * 文件缓存
		 */
		self::$container->set('fileCache', function() {
			$cacheDir = $this->getConfig()->application->cacheDir;
			if (!is_dir($cacheDir )) {
                @mkdir($cacheDir , 0755, true);
            }
			return new BackFile(new Data(), ['cacheDir' => $cacheDir]);
		});

		/**
		 * redis cache
		 */
		self::$container->setShared('redisCache', function(){
			return new RedisCache(new Data(), $this->getConfig()->cache->redis->toArray());
		});
		/**
		 * 微信配置
		 */
		self::$container->setShared('wechatConfig', function(){
			return new ConfigPhp($this->getConfig()->thirdParty->wechatPath);
		});

		/**
		 * 语言包配置
		 */
		self::$container->setShared('languageConfig', function(){
			return new ConfigPhp($this->getConfig()->language->zh_CN);
		});

		/**
		 * 加密
		 */
		self::$container->set('crypt', function () {
			$cryptConfig = $this->getConfig()->crypt;
	        $crypt = new Crypt();
	        $crypt->setCipher($cryptConfig->cipher);
	        $crypt->setKey($cryptConfig->key);
	        return $crypt;
		}, true);

		/**
		 * 安全
		 */
		self::$container->set('security', function(){
			$security = new \Phalcon\Security();
        	// Set the password hashing factor to 12 rounds
        	$security->setWorkFactor(12);
        	return $security;
		}, true);
	}
}
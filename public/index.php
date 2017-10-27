<?php

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('MODULES_PATH', APP_PATH . '/modules');

$loader = new \Phalcon\Loader();
$loader->registerFiles([
	APP_PATH . '/core/Loader.php',
	BASE_PATH . '/vendor/autoload.php'
]);
$loader->register();

Core\Loader::initialize($loader);
Core\Bootstrap::run();
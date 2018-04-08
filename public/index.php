<?php

//error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
//define('MODULES_PATH', APP_PATH . '/modules');

 $loader = new \Phalcon\Loader();

 $loader->registerFiles([
 	BASE_PATH . '/kernel/Loader.php',
 	BASE_PATH . '/vendor/autoload.php'
 ]);
 $loader->registerNamespaces([
     "Common\\Service" => BASE_PATH . '/common/service'
 ]);
 $loader->register();

 Kernel\Loader::initialize($loader);

 Kernel\Bootstrap::run();
//"endroid/qrcode": "^2.4.0",
//"overtrue/wechat": "^4.0.20"
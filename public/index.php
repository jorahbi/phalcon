<?php

//error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

 $loader = new \Phalcon\Loader();

 $loader->registerFiles([
 	BASE_PATH . '/kernel/Loader.php',
 	BASE_PATH . '/vendor/autoload.php'
 ]);

 $loader->register();

 Kernel\Loader::initialize($loader);

 Kernel\Bootstrap::run();
//"endroid/qrcode": "^2.4.0",
//"overtrue/wechat": "^4.0.20"
<?php

define('BASE_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', BASE_PATH . '/app');
$loader = new \Phalcon\Loader();

$loader->registerFiles([
    BASE_PATH . '/kernel/Loader.php',
    BASE_PATH . '/vendor/autoload.php'
]);

$loader->register();
Kernel\Container::setContainer(new \Phalcon\Di\FactoryDefault\Cli());
Kernel\Loader::setSpace([
    'Kernel\\Bin\\Helper'   => BASE_PATH . '/kernel/bin/helper',
    'Kernel\\Bin\\Commands' => BASE_PATH . '/kernel/bin/commands',
]);
Kernel\Loader::initialize($loader);

\Kernel\Bin\Helper\Bootstrap::start();

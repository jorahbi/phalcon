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
/*
class CommandContainer
{
    const NAME    = '';
    const VERSION = 'dev';

    private static $container;
    private static $app;
    private static $instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance  = new self();
            self::$instance->loader();
            self::$container = new \Phalcon\Di\FactoryDefault();
            self::$app       = new \Symfony\Component\Console\Application(self::NAME, self::VERSION);
            self::$container->setShared('config', function () {
                return new \Phalcon\Config\Adapter\Php(BASE_PATH . '/common/config/config.php');
            });

            self::$container->setShared('commandDb', function () {
                $config  = $this->get('config');
                $adapter = strtolower($config->database->adapter);
                return new \PDO(
                    "{$adapter}:dbname={$config->database->dbname};host={$config->database->host}",
                    $config->database->username,
                    $config->database->password
                );
            });
        }
        return self::$instance;
    }

    public function getService($serviceName)
    {
        return self::$container->get($serviceName);
    }

    public function setService($serviceName, $obj)
    {
        self::$container->setShared($serviceName, $obj);
    }

    public function start()
    {
        $this->addCommands();
        self::$app->run();
    }

    protected function loader()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerFiles([
            BASE_PATH . '/vendor/autoload.php',
        ]);

        $loader->registerNamespaces([
            'Kernel\\Bin\\Helper'   => BASE_PATH . '/kernel/bin/helper',
            'Kernel\\Bin\\Commands' => BASE_PATH . '/kernel/bin/commands',
        ]);
        $loader->register();
    }

    protected function addCommands()
    {
        self::$app->addCommands([
            new \Kernel\Bin\Commands\SchemaCommand(),
        ]);
    }
}

CommandContainer::getInstance()->start();*/
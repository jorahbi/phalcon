<?php

namespace Frontend\Config;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;
use Phalcon\Config\Adapter\Php as ConfigPhp;


class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $container
     */
    public function registerAutoloaders(DiInterface $container = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Frontend\\Controllers' => __DIR__ . '/controllers/',
            'Frontend\\Models' => __DIR__ . '/models/'
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $container
     */
    public function registerServices(DiInterface $container)
    {
        /**
         * Try to load local configuration
         */
        if (file_exists(__DIR__ . '/config.php')) {

            $config = $container->get('config')->getConfig();
            $override = new ConfigPhp(__DIR__ . '/config.php');
            if ($config instanceof Config) {
                $config->merge($override);
            } else {
                $container->set('config', $override);
            }
        }

        /**
         * Setting up the view component
         */
        $container->set('view',  function () {
            $view = new View();
            $view->setViewsDir(realpath($this->get('config')->getConfig()->application->viewsDir));

            $view->registerEngines([
                '.volt' => 'voltShared',
                '.phtml' => PhpEngine::class
            ]);

            return $view;
        });

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $container->set('db', function () {
            $config = $this->getConfig();

            $dbConfig = $config->database->toArray();

            $dbAdapter = '\Phalcon\Db\Adapter\Pdo\\' . $dbConfig['adapter'];
            unset($config['adapter']);

            return new $dbAdapter($dbConfig);
        });
    }
}

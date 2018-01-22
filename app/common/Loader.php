<?php

namespace Common;

use Phalcon\Config\Adapter\Php as ConfigPhp;

class Loader
{

    protected static $config;

    public static function initialize(\Phalcon\Loader $loader)
    {
        /**
         * Register Namespaces
         */
        self::$config = new ConfigPhp(APP_PATH . '/common/config/config.php');

        $namespace = self::$config->namespace->toArray();

        $modules = self::$config->modules->toArray();
        foreach ($modules as $key => $value) {
            $ucfirstKey                               = ucfirst($key);
            $namespace[$ucfirstKey . '\\Entity']      = MODULES_PATH . '/' . $key . '/entity';
            $namespace[$ucfirstKey . '\\Models']      = MODULES_PATH . '/' . $key . '/models';
            $namespace[$ucfirstKey . '\\Plugins']     = MODULES_PATH . '/' . $key . '/plugins';
            $namespace[$ucfirstKey . '\\Controllers'] = MODULES_PATH . '/' . $key . '/controllers';
        }

        $loader->registerNamespaces($namespace);

        /**
         * Register module classes
         */
        $loader->registerClasses(self::$config->classes->toArray());

        $loader->register();
        \Common\Service::setServer('config', self::$config);
    }
}

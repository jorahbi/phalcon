<?php

namespace Kernel;

use Phalcon\Config\Adapter\Php as ConfigPhp;

class Loader
{
    public static function initialize(\Phalcon\Loader $loader)
    {
        $namespace = [];

        $modules = Service::getService('config')->getConfig()->modules->toArray();
        foreach ($modules as $key => $value) {
            $ucfirstKey = ucfirst($key);
            $namespace[$ucfirstKey . '\\Entity'] = APP_PATH . '/' . $key . '/entity';
            $namespace[$ucfirstKey . '\\Models'] = APP_PATH . '/' . $key . '/models';
            $namespace[$ucfirstKey . '\\Plugins'] = APP_PATH . '/' . $key . '/plugins';
            $namespace[$ucfirstKey . '\\Controllers'] = APP_PATH . '/' . $key . '/controllers';
            $namespace[$ucfirstKey . '\\Config'] = APP_PATH . '/' . $key . '/config';
        }

        $loader->registerNamespaces($namespace);

        $loader->register();
    }
   
}

















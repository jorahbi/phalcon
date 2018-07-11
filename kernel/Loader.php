<?php

namespace Kernel;

class Loader
{
    private static $spaces = [];

    public static function initialize(\Phalcon\Loader $loader, Array $spaces = [])
    {
        self::$spaces = array_merge(self::$spaces, $spaces);
        $modules = Container::getService('config')->getConfig()->modules->toArray();
        foreach ($modules as $key => $value) {
            $ucFirstKey = ucfirst($key);
            self::$spaces[$ucFirstKey . '\\Entity'] = APP_PATH . '/' . $key . '/entity';
            self::$spaces[$ucFirstKey . '\\Models'] = APP_PATH . '/' . $key . '/models';
            self::$spaces[$ucFirstKey . '\\Plugins'] = APP_PATH . '/' . $key . '/plugins';
            self::$spaces[$ucFirstKey . '\\Controllers'] = APP_PATH . '/' . $key . '/controllers';
            self::$spaces[$ucFirstKey . '\\Config'] = APP_PATH . '/' . $key . '/config';
        }
        $loader->registerNamespaces(self::$spaces);

        $loader->register();
    }
   
}

















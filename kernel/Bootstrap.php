<?php

namespace Kernel;

use Phalcon\Mvc\Application;

class Bootstrap
{

    public static function run()
    {
        //try {

            Service::getService('router')->init();
            $application = new Application(Service::getContainer());

            /**
             * Register application modules
             */
            $application->registerModules(Service::getService('config')->getConfig()->modules->toArray());

            //debug
            (new \Phalcon\Debug())->listen();

            $application->handle()->send();

//        } catch (\Exception $e) {
//            echo $e->getMessage() . '<br>';
//            echo '<pre>' . $e->getTraceAsString() . '</pre>';
//        }
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }
}

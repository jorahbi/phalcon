<?php

defined('BASE_PATH') or define('BASE_PATH', dirname(__DIR__));
defined('APP_PATH') or define('APP_PATH', BASE_PATH . '/app');


return [
    'version' => '1.0',

    'database' => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'dbname'   => 'phalcon',
        'charset'  => 'utf8',
    ],

    'application' => [
        'appDir'         => APP_PATH . '/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'cacheDir'       => BASE_PATH . '/cache/',
        

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => '/',
        'defaultModule' => 'frontend',
        'defaultNamespace' => 'Frontend\\Controllers',
        'defaultController' => 'index',
        'defaultAction' => 'index',
        'modulePath' => APP_PATH . '/modules/'
    ],
    'cache' => [
        'lefttime' => 172800,
        'modelDir' => BASE_PATH . '/cache/model/',
    ],
    //第三方
    'thirdParty' => [
        'wechatPath' => APP_PATH . '/common/config/wechat.php'
    ],

    /**
     * if true, then we print a new line at the end of each CLI execution
     *
     * If we dont print a new line,
     * then the next command prompt will be placed directly on the left of the output
     * and it is less readable.
     *
     * You can disable this behaviour if the output of your application needs to don't have a new line at end
     */
    'printNewLine' => true
];



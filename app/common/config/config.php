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
        'baseUri'        => '/',
        'defaultModule' => 'frontend',
        'defaultNamespace' => 'Frontend\\Controllers',
        'defaultController' => 'index',
        'defaultAction' => 'index',
    ],
    'cache' => [
        'redis' => [
            'host'       => '127.0.0.1',
            'port'       => 6379,
            'auth'       => '',
            'persistent' => false,
            'index'      => 0,
        ],
        'model' => [
            'path' => BASE_PATH . '/cache/model/',
            'lefttime' => 172800
        ]
    ],
    //第三方
    'thirdParty' => [
        'wechatPath' => APP_PATH . '/common/config/wechat.php'
    ],

    //语言包
    'language' => [
        'zh_CN' => APP_PATH . '/common/config/language/zh_CN.php',
    ],

    ///加密
    'crypt' => [
        //@link http://www.iphalcon.cn/reference/crypt.html
        'key' => '%31.1e$i86e$f!8jz',
        'cipher' => 'aes-256-cfb'
    ],
    //cookie
    'cookies' => [
        'expire' => 86400,
        'encrypt' => true
    ],
    //session 会话
    'session' => [
        'adapter' => '\\Phalcon\\Session\\Adapter\\Files',
        'expire' => 3600,
        //construct params
        'options' => [
            'uniqueId'   => 'ebizsoft',
        ]
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



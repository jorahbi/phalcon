<?php

defined('BASE_PATH') or define('BASE_PATH', dirname(__DIR__));
defined('APP_PATH') or define('APP_PATH', BASE_PATH . '/app');

return [
    'version'      => '1.0',

    'database'     => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ],

    'namespace'    => [
        'Common'                   => APP_PATH . '/common',
        'Service\\Wechat\\User'    => APP_PATH . '/service/wechat/user',
        'Service\\Wechat\\Message' => APP_PATH . '/service/wechat/message',
        'Service\\Wechat\\Common'  => APP_PATH . '/service/wechat/common',
        'Service\\Wechat'          => APP_PATH . '/service/wechat',

        'Service\\Swoole\\Server'  => APP_PATH . '/service/swoole/server',
        'Service\\Swoole\\Task'    => APP_PATH . '/service/swoole/task',
        'Service\\Swoole\\Event'   => APP_PATH . '/service/swoole/event',
    ],

    'classes'      => [
        'Frontend\\Module' => MODULES_PATH . '/frontend/Module.php',
        'Admin\\Module'    => MODULES_PATH . '/admin/Module.php',
        'Product\\Module'  => MODULES_PATH . '/product/Module.php',
        'Passport\\Module' => MODULES_PATH . '/passport/Module.php',
    ],

    'modules'      => [
        'frontend' => [
            'className' => 'Frontend\\Module',
            'path'      => APP_PATH . '/modules/frontend/Module.php',
        ],
        'admin'    => [
            'className' => 'Admin\\Module',
            'path'      => APP_PATH . '/modules/admin/Module.php',
        ],
    ],

    'application'  => [
        'appDir'        => APP_PATH . '/',
        'migrationsDir' => APP_PATH . '/migrations/',
        'cacheDir'      => BASE_PATH . '/cache/',
        'modulePath'    => APP_PATH . '/modules/',
        'baseUri'       => '/',
    ],
    'cache'        => [
        'redis' => [
            'host'       => '127.0.0.1',
            'port'       => 6379,
            'auth'       => '',
            'persistent' => false,
            'index'      => 0,
        ],
        'model' => [
            'path'     => BASE_PATH . '/cache/model/',
            'lefttime' => 172800,
        ],
    ],
    //第三方
    'thirdParty'   => [
        'wechatPath' => APP_PATH . '/common/config/wechat.php',
    ],

    //语言包
    'language'     => [
        'zh_CN' => APP_PATH . '/common/config/language/zh_CN.php',
    ],

    ///加密
    'crypt'        => [
        //@link http://www.iphalcon.cn/reference/crypt.html
        'key'    => '%31.1e$i86e$f!8jz',
        'cipher' => 'aes-256-cfb',
    ],
    //cookie
    'cookies'      => [
        'expire'  => 86400,
        'encrypt' => true,
    ],
    //session 会话
    'session'      => [
        'adapter' => '\\Phalcon\\Session\\Adapter\\Files',
        'expire'  => 3600,
        //construct params
        'options' => [
            'uniqueId' => 'ebizsoft',
        ],
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
    'printNewLine' => true,

];

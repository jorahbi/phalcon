<?php

namespace Kernel\Service;

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Cache\Frontend\Data;


/**
 * Class MysqlService
 * mysql service
 */
class MysqlService extends Mysql implements ServiceInterface
{
    public function __construct(ConfigService $config)
    {
        $config = $config->getConfig();
        $params = [
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname,
            'charset' => $config->database->charset,
        ];
        parent::__construct($params);
    }
}
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
    public function __construct(ConfigService $config, string $schema)
    {
        $config = $config->getConfig();
        $params = [
            'host' => $config->{$schema}->host,
            'username' => $config->{$schema}->username,
            'password' => $config->{$schema}->password,
            'dbname' => $config->{$schema}->dbname,
            'charset' => $config->{$schema}->charset,
        ];
        parent::__construct($params);
    }
}
<?php

namespace Kernel\Service;

use Phalcon\Config;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data;


/**
 * Class RedisService
 * redis service
 */
class RedisService extends Redis implements ServiceInterface
{
    public function __construct(Config $config)
    {
        parent::__construct(new Data(), $config->cache->redis->toArray());
    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/1
 * Time: 下午9:42
 */

namespace Kernel\Service;

use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend\File as BackFile;

class ModelsCacheService implements ServiceInterface
{
    public function __construct(ConfigService $config)
    {
        $config = $config->getConfig()->cache->model;
        if (!is_dir($config->fileDir)) {
            @mkdir($config->fileDir, 0755, true);
        }
        return new BackFile(
            new Data(['lifetime' => $config->lefttime]),
            ['cacheDir' => $config->modelDir]
        );
    }
}
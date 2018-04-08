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

class FileService implements ServiceInterface
{
    public function __construct(ConfigService $config)
    {
        $cacheDir = $config->getConfig()->application->cacheDir;
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        return new BackFile(new Data(), ['cacheDir' => $cacheDir]);
    }
}
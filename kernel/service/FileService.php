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
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View;

class FileService implements ServiceInterface
{
    private $config;

    public function __construct(ConfigService $config)
    {
        $this->config = $config;
        $cacheDir = $this->config->getConfig()->application->runtime;
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        return new BackFile(new Data(), ['cacheDir' => $cacheDir]);
    }

    /**
     * volt 模板缓存
     * @param View $view
     * @return VoltEngine
     */
    public function volt(View $view)
    {
        $runtime = $this->config->getConfig()->application->runtime;

        $volt = new VoltEngine($view);
        $volt->setOptions([
            'compileAlways' => false,
            'compiledPath' => function ($templatePath) use ($runtime) {

                $filename = md5($templatePath) . '.php';
                if (!is_dir($runtime . DIRECTORY_SEPARATOR . 'volt')) {
                    @mkdir($runtime . DIRECTORY_SEPARATOR . 'volt', 0755, true);
                }

                return $runtime . DIRECTORY_SEPARATOR . 'volt' . DIRECTORY_SEPARATOR . $filename;
            },
        ]);
        return $volt;
    }
}
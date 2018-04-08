<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/1
 * Time: 下午9:42
 */

namespace Kernel\Service;

use Phalcon\Session\Adapter\Files;

class SessionService extends Files implements ServiceInterface
{
    public function __construct(ConfigService $config)
    {
        parent::__construct($config->getConfig()->session->options->toArray());
        $this->start();
    }
}
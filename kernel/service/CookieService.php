<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/1
 * Time: 下午9:42
 */

namespace Kernel\Service;

use Phalcon\Http\Response\Cookies;

class CookieService extends Cookies implements ServiceInterface
{
    public function __construct(ConfigService $config)
    {
        $this->useEncryption($config->getConfig()->cookies->expire);

    }
}
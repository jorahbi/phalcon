<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/1
 * Time: 下午9:42
 */

namespace Kernel\Service;

use Phalcon\Security;

class SecurityService extends Security implements ServiceInterface
{
    public function __construct()
    {
        $this->setWorkFactor(12);
    }
}
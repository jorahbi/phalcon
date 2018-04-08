<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/1
 * Time: 下午9:42
 */

namespace Kernel\Service;

use Phalcon\Crypt;

class CryptService extends Crypt implements ServiceInterface
{
    public function __construct(ConfigService $config)
    {
        $cryptConfig = $config->getConfig()->crypt;
        $this->setCipher($cryptConfig->cipher);
        $this->setKey($cryptConfig->key);
    }
}
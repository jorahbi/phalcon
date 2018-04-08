<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/1
 * Time: 下午9:42
 */

namespace Kernel\Service;

use Phalcon\Config\Adapter\Php as ConfigPhp;

class ConfigService implements ServiceInterface
{
    private static $config;
    private static $wechat;
    private static $language;

    /**
     * @return ConfigPhp
     */
    public function getConfig()
    {
        if(empty(self::$config)){
            self::$config =  new ConfigPhp(BASE_PATH . '/common/config/config.php');
        }
        return self::$config;
    }

    public function getWechat()
    {
        if(empty(self::$wechat)){
            self::$wechat = new ConfigPhp($this->getConfig()->thirdParty->wechatPath);
        }
        return self::$wechat;
    }

    public function getLanguage()
    {
        if(empty(self::$language)){
            self::$language = new ConfigPhp($this->getConfig()->language->zh_CN);
        }
        return self::$language;
    }

}
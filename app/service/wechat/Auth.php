<?php

namespace Service\Wechat;

use Service\Wechat\Common\Config;
use Service\Wechat\Common\Curl;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Json;
use Common\Service;

/**
 * 微信用户授权
 */
class Auth
{
	/**
     * Description: 获取CODE
     * @param $scope snsapi_base不弹出授权页面，只能获得OpenId;snsapi_userinfo弹出授权页面，可以获得所有信息
     * 将会跳转到redirect_uri/?code=CODE&state=STATE 通过GET方式获取code和state
     */
	public static function getCode($scope='snsapi_base')
	{
		$config = Config::getConfig();
        $params['appid'] = $config->wechatAppID;
		$params['redirect_uri'] = $config->loginRedirect;
		$params['response_type'] = 'code';
		$params['scope'] = $scope;
		$params['state'] = $config->state;
		$url = $config->getCode . http_build_query($params) . '#wechat_redirect';
        header('Location: '.$url, true, 301);
	}

	/**
     * Description: 通过code换取网页授权access_token
     * 首先请注意，这里通过code换取的网页授权access_token,与基础支持中的access_token不同。
     * 公众号可通过下述接口来获取网页授权access_token。
     * 如果网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
     * @param $code getCode()获取的code参数
     *
     * @return Array(access_token, expires_in, refresh_token, openid, scope)
     */
    public static function getAccessTokenAndOpenId($code)
    {
        //$cache = Config::getCacheServer();
        /*$cacheKey = md5($result['openid']);
    	if($cache->exists($cacheKey))
        {
            return $cache->get($cacheKey);
        }*/
        $config = Config::getConfig();
    	$params['appid'] = $config->wechatAppID;
    	$params['secret'] = $config->wechatAppsecret;
    	$params['code'] = $code;
    	$params['grant_type'] = 'authorization_code';
    	$url = $config->getWebAccessToken . http_build_query($params);
        $result = Curl::callWebServer($url);
        /*if(isset($result['access_token']))
        {
            $cache->save($config->cacheDir . $cacheKey, $result, 7100);
        }*/
        return $result;
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * 如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。
     * @param $accessToken 网页授权接口调用凭证。通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是access_token，就是这里的参数。注意：此access_token与基础支持的access_token不同
     * @param $openId 用户的唯一标识
     * @param $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     *
     * @return array("openid"=>"用户的唯一标识",
                     "nickname"=>'用户昵称',
                     "sex"=>"1是男，2是女，0是未知",
                     "province"=>"用户个人资料填写的省份"
                     "city"=>"普通用户个人资料填写的城市",
                     "country"=>"国家，如中国为CN",
                     //户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
                     "headimgurl"=>"http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
                     //用户特权信息，json 数组，如微信沃卡用户为chinaunicom
                     "privilege"=>array("PRIVILEGE1", "PRIVILEGE2"),
                );
     */
    public static function getUserInfo($accessToken, $openId, $lang='zh_CN')
    {
    	$config = Config::getConfig();
    	$queryUrl = $config->getUserInfo . 'access_token=' . $accessToken . '&openid='. $openId .'&lang=zh_CN';
        return Curl::callWebServer($queryUrl);
    }

    public static function getAccessToken()
    {

    }

    /**
     * 刷新access_token（如果需要）
     * 由于access_token拥有较短的有效期，当access_token超时后，可以使用refresh_token进行刷新，refresh_token拥有较长的有效期（7天、30天、60天、90天），当refresh_token失效的后，需要用户重新授权。
     * @param $refreshToken 通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是refresh_token，就是这里的参数
     *
     * @return array(
        "access_token"=>"网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同",
        "expires_in"=>access_token接口调用凭证超时时间，单位（秒）,
        "refresh_token"=>"用户刷新access_token",
        "openid"=>"用户唯一标识",
        "scope"=>"用户授权的作用域，使用逗号（,）分隔")
     */
    public static function refreshToken($refreshToken)
    {
        $config = Config::getConfig();
        $queryUrl = $config->refreshWebToken .
        'appid=' . $config->wechatAppID . '&grant_type=refresh_token&refresh_token='.$refreshToken;
        return Curl::callWebServer($queryUrl);
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @param $accessToken 网页授权接口调用凭证。通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是access_token，就是这里的参数。注意：此access_token与基础支持的access_token不同
     * @param $openId
     * @return array("errcode"=>0,"errmsg"=>"ok")
     */
    public static function checkAccessToken($accessToken, $openId)
    {
        $queryUrl = Config::getConfig()->checkWebAccessToken . 'access_token='.$accessToken.'&openid='.$openId;
        return Curl::callWebServer($queryUrl);
    }

    /**
     * 获取基础的 access token
     */
    public static function getBaseAccessToken()
    {
        $config = Config::getConfig();
        $cache = Config::getCacheServer();
        $cacheKey = md5($config->wechatAppID);
        if($cache->exists($cacheKey))
        {
            $result = $cache->get($cacheKey);
            return $result['access_token'];
        }
        $queryUrl = $config->getBaseAccessToken . 'appid=' . $config->wechatAppID . '&secret=' . $config->wechatAppsecret;
        $result = Curl::callWebServer($queryUrl);
        if(!isset($result['access_token']))
        {
            die('获取access token 失败');
        }
        $cache->save($config->cacheDir . $cacheKey, $result, 7100);

        return $result['access_token'];
    }
}

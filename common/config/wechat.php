<?php

return [
	/**
	 * 服务器配置，详情请参考
	 * @link http://mp.weixin.qq.com/wiki/index.php?title=接入指南
	 */
	'wechatUrl' => '',
	'wechatToken' => 'wechat',
	'encodingAesKey' => '',
	'state' => 1,
	/**
	 * 开发者配置
	 */
	'wechatAppID' => 'wxa4402973fd06422d',
	'wechatAppsecret' => 'd4624c36b6795d1d99dcf0547af5443d',
	/**
	 * redirect 回调
	 */
	'loginRedirect' => 'http://testing.ecbig.cn/index/test',
	/**
	 * 网页开发request 请求
	 */
	'getCode' => 'https://open.weixin.qq.com/connect/oauth2/authorize?',
	'getWebAccessToken' => 'https://api.weixin.qq.com/sns/oauth2/access_token?',
	'getUserInfo' => 'https://api.weixin.qq.com/sns/userinfo?',
	'refreshWebToken' => 'https://api.weixin.qq.com/sns/oauth2/refresh_token?',
	'checkWebAccessToken' => 'https://api.weixin.qq.com/sns/auth?',

	//获取基础 access token
	'getBaseAccessToken' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&',

	//菜单 
	'setMenu' => 'https://api.weixin.qq.com/cgi-bin/menu/create?',
	'getMenu' => 'https://api.weixin.qq.com/cgi-bin/menu/get?',
	/**
	 * 缓存
	 */
	'cacheDir' => 'wechat/'
];
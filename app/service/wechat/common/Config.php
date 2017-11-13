<?php

namespace Service\Wechat\Common;

use Common\Service;

class Config
{
	public static function getConfig($key = '')
	{
		$config = Service::getContainer()->get('wechatConfig');
		if(empty($key))
		{
			return $config;
		}
		if(property_exists($config, $key))
		{
			return $config->$key;			
		}
		return null;
	}

	public static function getCacheServer($serverName = 'fileCache')
	{
		return Service::getContainer()->get($serverName);
	}	
} 
<?php

namespace Service\Wechat\Common;

class Utils
{
	/**
	 * 数组转换url参数
	 */
	public static function httpBuildQuery(Array $urlParam)
	{
	    if ($urlParam == null) return '';
	    $url = '';
	    foreach ($urlParam as $k => $v)
	    {
	        if($k == 'sign') continue;
	        $url .= '&' . $k . '=' . $v ;
	    }
	    
	    return trim($url, '&');
	}
}
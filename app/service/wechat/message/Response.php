<?php

namespace Service\Wechat\Message;

use Service\Wechat\Common\Utils;

class Response
{
	public static function handle(Request $request)
	{
		$params = $request->getParam();
		if(!method_exists('\\Service\\Wechat\\Message\\Response', $request->getParam('msgtype')))
		{
			//未知消息类型
			return ResponseTemplate::text($params['fromusername'], $params['tousername'], '收到未知的消息，我不知道怎么处理');
		}
		$msgAction = $params['msgtype'];
		return self::$msgAction($params);
	}

	public static function event(&$params)
	{
		$eventAction = 'event';
		$eventTmp = explode('_', strtolower($params['event']));
		foreach ($eventTmp as $value) 
		{
			$eventAction .= ucfirst($value);
		}
		return self::$eventAction($params);
	}

    /**
     * @descrpition 文本
     * @param $params
     * @return array
     */
    protected static function text(&$params)
    {
        $content = '收到文本消息';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 图像
     * @param $params
     * @return array
     */
    protected static function image(&$params)
    {
        $content = '收到图片';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 语音
     * @param $params
     * @return array
     */
    protected static function voice(&$params)
    {
        if(!isset($params['recognition'])){
            $content = '收到语音';
            return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
        }else{
            $content = '收到语音识别消息，语音识别结果为：'.$params['recognition'];
            return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
        }
    }

    /**
     * @descrpition 视频
     * @param $params
     * @return array
     */
    protected static function video(&$params)
    {
        $content = '收到视频';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 视频
     * @param $params
     * @return array
     */
    protected static function shortvideo(&$params)
    {
        $content = '收到小视频';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 地理
     * @param $params
     * @return array
     */
    protected static function location(&$params)
    {
        $content = '收到上报的地理位置';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 链接
     * @param $params
     * @return array
     */
    protected static function link(&$params)
    {
        $content = '收到连接';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 关注
     * @param $params
     * @return array
     */
    protected static function eventSubscribe(&$params)
    {
    	 //二维码关注
    	if(isset($request['eventkey']) && isset($request['ticket']))
    	{
            return self::eventQrsceneSubscribe($params);
        }

        $content = '欢迎您关注我们的微信，将为您竭诚服务.';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 取消关注
     * @param $params
     * @return array
     */
    protected static function eventUnsubscribe(&$params)
    {
        $content = '为什么不理我了？';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 扫描二维码关注（未关注时）
     * @param $params
     * @return array
     */
    protected static function eventQrsceneSubscribe(&$params)
    {
        /*
        *用户扫描带参数二维码进行自动分组
        *此处添加此代码是大多数需求是在扫描完带参数二维码之后对用户自动分组
        */
        $sceneid = str_replace("qrscene_","",$params['eventkey']);
        //移动用户到相应分组中去,此处的$sceneid依赖于之前创建时带的参数
        if(!empty($sceneid)){
            UserManage::editUserGroup($params['fromusername'], $sceneid);
            $result=UserManage::getGroupByOpenId($params['fromusername']);
            //方便开发人员调试时查看参数正确性
            $content = '欢迎您关注我们的微信，将为您竭诚服务。二维码Id:'.$result['groupid'];
        }else
            $content = '欢迎您关注我们的微信，将为您竭诚服务。';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 扫描二维码（已关注时）
     * @param $params
     * @return array
     */
    protected static function eventScan(&$params)
    {
        $content = '您已经关注了哦～';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 上报地理位置
     * @param $params
     * @return array
     */
    protected static function eventLocation(&$params)
    {
        $content = '收到上报的地理位置';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 点击菜单拉取消息时的事件推送
     * @param $params
     * @return array
     */
    protected static function eventClick(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到点击菜单事件，您设置的key是' . $eventKey;
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 点击菜单跳转链接时的事件推送
     * @param $params
     * @return array
     */
    protected static function eventView(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到跳转链接事件，您设置的key是' . $eventKey;
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 扫码推事件的事件推送
     * @param $params
     * @return array
     */
    protected static function eventScancodePush(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到扫码推事件的事件，您设置的key是' . $eventKey;
        $content .= '。扫描信息：'.$params['scancodeinfo'];
        $content .= '。扫描类型(一般是qrcode)：'.$params['scantype'];
        $content .= '。扫描结果(二维码对应的字符串信息)：'.$params['scanresult'];
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 扫码推事件且弹出“消息接收中”提示框的事件推送
     * @param $params
     * @return array
     */
    protected static function eventScancodeWaitmsg(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到扫码推事件且弹出“消息接收中”提示框的事件，您设置的key是' . $eventKey;
        $content .= '。扫描信息：'.$params['scancodeinfo'];
        $content .= '。扫描类型(一般是qrcode)：'.$params['scantype'];
        $content .= '。扫描结果(二维码对应的字符串信息)：'.$params['scanresult'];
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 弹出系统拍照发图的事件推送
     * @param $params
     * @return array
     */
    protected static function eventPicSysphoto(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到弹出系统拍照发图的事件，您设置的key是' . $eventKey;
        $content .= '。发送的图片信息：'.$params['sendpicsinfo'];
        $content .= '。发送的图片数量：'.$params['count'];
        $content .= '。图片列表：'.$params['piclist'];
        $content .= '。图片的MD5值，开发者若需要，可用于验证接收到图片：'.$params['picmd5sum'];
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 弹出拍照或者相册发图的事件推送
     * @param $params
     * @return array
     */
    protected static function eventPicPhotoOrAlbum(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到弹出拍照或者相册发图的事件，您设置的key是' . $eventKey;
        $content .= '。发送的图片信息：'.$params['sendpicsinfo'];
        $content .= '。发送的图片数量：'.$params['count'];
        $content .= '。图片列表：'.$params['piclist'];
        $content .= '。图片的MD5值，开发者若需要，可用于验证接收到图片：'.$params['picmd5sum'];
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 弹出微信相册发图器的事件推送
     * @param $params
     * @return array
     */
    protected static function eventPicWeixin(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到弹出微信相册发图器的事件，您设置的key是' . $eventKey;
        $content .= '。发送的图片信息：'.$params['sendpicsinfo'];
        $content .= '。发送的图片数量：'.$params['count'];
        $content .= '。图片列表：'.$params['piclist'];
        $content .= '。图片的MD5值，开发者若需要，可用于验证接收到图片：'.$params['picmd5sum'];
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * @descrpition 自定义菜单 - 弹出地理位置选择器的事件推送
     * @param $params
     * @return array
     */
    protected static function eventLocationSelect(&$params)
    {
        //获取该分类的信息
        $eventKey = $params['eventkey'];
        $content = '收到点击跳转事件，您设置的key是' . $eventKey;
        $content .= '。发送的位置信息：'.$params['sendlocationinfo'];
        $content .= '。X坐标信息：'.$params['location_x'];
        $content .= '。Y坐标信息：'.$params['location_y'];
        $content .= '。精度(可理解为精度或者比例尺、越精细的话 scale越高)：'.$params['scale'];
        $content .= '。地理位置的字符串信息：'.$params['label'];
        $content .= '。朋友圈POI的名字，可能为空：'.$params['poiname'];
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * 群发接口完成后推送的结果
     *
     * 本消息有公众号群发助手的微信号“mphelper”推送的消息
     * @param $params
     */
    protected static function eventMasssendjobfinish(&$params)
    {
        //发送状态，为“send success”或“send fail”或“err(num)”。但send success时，也有可能因用户拒收公众号的消息、系统错误等原因造成少量用户接收失败。err(num)是审核失败的具体原因，可能的情况如下：err(10001), //涉嫌广告 err(20001), //涉嫌政治 err(20004), //涉嫌社会 err(20002), //涉嫌色情 err(20006), //涉嫌违法犯罪 err(20008), //涉嫌欺诈 err(20013), //涉嫌版权 err(22000), //涉嫌互推(互相宣传) err(21000), //涉嫌其他
        $status = $params['status'];
        //计划发送的总粉丝数。group_id下粉丝数；或者openid_list中的粉丝数
        $totalCount = $params['totalcount'];
        //过滤（过滤是指特定地区、性别的过滤、用户设置拒收的过滤，用户接收已超4条的过滤）后，准备发送的粉丝数，原则上，FilterCount = SentCount + ErrorCount
        $filterCount = $params['filtercount'];
        //发送成功的粉丝数
        $sentCount = $params['sentcount'];
        //发送失败的粉丝数
        $errorCount = $params['errorcount'];
        $content = '发送完成，状态是'.$status.'。计划发送总粉丝数为'.$totalCount.'。发送成功'.$sentCount.'人，发送失败'.$errorCount.'人。';
        return ResponseTemplate::text($params['fromusername'], $params['tousername'], $content);
    }

    /**
     * 群发接口完成后推送的结果
     *
     * 本消息有公众号群发助手的微信号“mphelper”推送的消息
     * @param $params
     */
    protected static function eventTemplatesendjobfinish(&$params)
    {
        //发送状态，成功success，用户拒收failed:user block，其他原因发送失败failed: system failed
        $status = $params['status'];
        if($status == 'success'){
            //发送成功
        }else if($status == 'failed:user block'){
            //因为用户拒收而发送失败
        }else if($status == 'failed: system failed'){
            //其他原因发送失败
        }
        return true;
    }


    protected static function test()
    {
        // 第三方发送消息给公众平台
        $encodingAesKey = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG";
        $token = "pamtest";
        $timeStamp = "1409304348";
        $nonce = "xxxxxx";
        $appId = "wxb11529c136998cb6";
        $text = "<xml><ToUserName><![CDATA[oia2Tj我是中文jewbmiOUlr6X-1crbLOvLw]]></ToUserName><FromUserName><![CDATA[gh_7f083739789a]]></FromUserName><CreateTime>1407743423</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[eYJ1MbwPRJtOvIEabaxHs7TX2D-HV71s79GUxqdUkjm6Gs2Ed1KF3ulAOA9H1xG0]]></MediaId><Title><![CDATA[testCallBackReplyVideo]]></Title><Description><![CDATA[testCallBackReplyVideo]]></Description></Video></xml>";


        $pc = new Aes\WXBizMsgCrypt($token, $encodingAesKey, $appId);
        $encryptMsg = '';
        $errCode = $pc->encryptMsg($text, $timeStamp, $nonce, $encryptMsg);
        if ($errCode == 0) {
            print("加密后: " . $encryptMsg . "\n");
        } else {
            print($errCode . "\n");
        }

        $xml_tree = new \DOMDocument();
        $xml_tree->loadXML($encryptMsg);
        $array_e = $xml_tree->getElementsByTagName('Encrypt');
        $array_s = $xml_tree->getElementsByTagName('MsgSignature');
        $encrypt = $array_e->item(0)->nodeValue;
        $msg_sign = $array_s->item(0)->nodeValue;

        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $from_xml = sprintf($format, $encrypt);

// 第三方收到公众号平台发送的消息
        $msg = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        if ($errCode == 0) {
            print("解密后: " . $msg . "\n");
        } else {
            print($errCode . "\n");
        }
    }

}
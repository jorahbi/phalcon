<?php

namespace Service\Wechat\Message;

use Service\Wechat\Common\Utils;
use Service\Wechat\Message\Response;

/**
 * 微信请求
 */
class Request
{
    /**
     * 调试模式，将错误通过文本消息回复显示
     * @var boolean
     */
    private $debug;

    /**
     * 以数组的形式保存微信服务器每次发来的请求
     * @var array
     */
    private $params;

    /**
     * 判断此次请求是否为验证请求
     * @return boolean
     */
    private function isValid() 
    {
        return isset($_GET['echostr']);
    }

    /**
     * 判断验证请求的签名信息是否正确
     * @param  string $token 验证信息
     * @return boolean
     */
    private function validateSignature() 
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = Utils::getConfig()->wechatToken;
        $signatureArray = array($token, $timestamp, $nonce);
        sort($signatureArray, SORT_STRING);
        return sha1(implode($signatureArray)) == $signature;
    }

    /**
     * 获取本次请求中的参数，不区分大小
     * @param  string $param 参数名，默认为无参
     * @return mixed
     */
    public function getParam($param = false) 
    {
        if ($param === false) {
            return $this->params;
        }
        $param = strtolower($param);
        if (isset($this->params[$param])) {
            return $this->params[$param];
        }
        return null;
    }

    /**
     * 分析消息类型，并分发给对应的函数
     * @return void
     */
    public function run($debug = false) 
    {
    	//未通过消息真假性验证
       if ($this->isValid() && $this->validateSignature()) 
        {
            return $_GET['echostr'];
        }
        //是否打印错误报告
        $this->debug = $debug;
        //接受并解析微信中心POST发送XML数据
        $xml = (array) simplexml_load_string(file_get_contents('php://input'), 'SimpleXMLElement', LIBXML_NOCDATA);

        //将数组键名转换为小写
        $this->params = array_change_key_case($xml, CASE_LOWER);

        return Response::handle($this);
    }
/*
    public function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = WECHAT_TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }*/
}
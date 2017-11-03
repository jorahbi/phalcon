<?php

namespace Frontend\Controllers;

class IndexController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

        //header("Access-Control-Allow-Origin: http://passport.com");
        //$this->session->setId(md5(urldecode($_GET['token'])));
        if($this->request->isGet() && $this->request->get('token'))
        {

        }
        if(isset($_GET['token']))
            setcookie('token', $_GET['token'], time() + 24 * 60 * 60);
        $this->session->set('index11', $_GET['token']);
        //file_put_contents('test', date('Y-m-d H:i:s', time()));
        //$this->session->destroy(true);
        //echo  'returnjs({"code":"aa", "ccc": "ddd", "sessionId": "' . md5(urldecode($_GET['token'])) . '"})';  die;
    }

    public function testAction()
    {
        //$this->session->set('test', 'aaaaaaaa');
        var_dump($this->cookies->get('token')->getValue());
        die('index test');
    }

    /**
     * 微信请求
     */
    public function wechatAction()
    {
        $wechatRequest = new \Service\Wechat\Message\Request();
        return $wechatRequest->run();
    }

    public function test1Action()
    {
        \Service\Wechat\Auth::getCode('snsapi_userinfo');  
        $result = \Service\Wechat\Auth::getAccessTokenAndOpenId($this->request->get('code'));
        $userInfo = \Service\Wechat\Auth::getUserInfo($result['access_token'], $result['openid']);
        
    }

    public function menuAction()
    {
        $menuList = array(
            array('id'=>'1', 'pid'=>'',  'name'=>'常规', 'type'=>'', 'code'=>'key_1'),
            array('id'=>'2', 'pid'=>'1',  'name'=>'点击', 'type'=>'click', 'code'=>'key_2'),
            array('id'=>'3', 'pid'=>'1',  'name'=>'浏览', 'type'=>'view', 'code'=>'http://www.lanecn.com'),
            array('id'=>'4', 'pid'=>'',  'name'=>'扫码', 'type'=>'', 'code'=>'key_4'),
            array('id'=>'5', 'pid'=>'4', 'name'=>'扫码带提示', 'type'=>'scancode_waitmsg', 'code'=>'key_5'),
            array('id'=>'6', 'pid'=>'4', 'name'=>'扫码推事件', 'type'=>'scancode_push', 'code'=>'key_6'),
            array('id'=>'7', 'pid'=>'',  'name'=>'发图', 'type'=>'', 'code'=>'key_7'),
            array('id'=>'8', 'pid'=>'7', 'name'=>'系统拍照发图', 'type'=>'pic_sysphoto', 'code'=>'key_8'),
            array('id'=>'9', 'pid'=>'7', 'name'=>'拍照或者相册发图', 'type'=>'pic_photo_or_album', 'code'=>'key_9'),
            array('id'=>'10', 'pid'=>'7', 'name'=>'微信相册发图', 'type'=>'pic_weixin', 'code'=>'key_10'),
            array('id'=>'11', 'pid'=>'1', 'name'=>'发送位置', 'type'=>'location_select', 'code'=>'key_11'),
        );
    	file_put_contents('menu', var_export(\Service\Wechat\Menu::setMenu($menuList), true));
        print_r(\Service\Wechat\Menu::getMenu());
    }

    public function route404Action()
    {
        die('404');
    }
}


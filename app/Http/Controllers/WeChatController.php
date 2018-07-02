<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/5
 * Time: 16:47
 */
namespace App\Http\Controllers;

use App\Http\Library\WechatLibrary;
use Illuminate\Http\Request;

class WeChatController extends Controller{

    private static $user_agent= [
        'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36',
        'Mozilla/5.0 (Windows NT 5.1; U; en; rv:1.8.1) Gecko/20061208 Firefox/2.0.0 Opera 9.50',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 ',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11',
        'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.133 Safari/534.16',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.11 TaoBrowser/2.0 ',
    ];

    /**
     * @param Request $request
     */
    public function index(Request $request){

        $data = file_get_contents('php://input');

        //载入xml解析
        $data = (array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

        $message = '';
        switch (strtolower($data['MsgType'])){
            case 'text':
                $message = $this->getRandomMessage($data['Content']);         //根据发送的消息随机发送用户信息
                break;
            default:
                break;
        }

        $template =<<<EOF
                        <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                       </xml>
EOF;

        $data = sprintf($template, $data['FromUserName'], $data['ToUserName'], time(), $data['MsgType'], $message);

        echo $data;
    }


    /**
     * 随机发送用户信息
     * @param $message
     * @return bool
     */
    private function getRandomMessage($message){
        //这个是小黄鸡的接口地址
        $url = "http://www.niurenqushi.com/api/simsimi/";

        $user_agent = self::$user_agent[rand(0, count(self::$user_agent)-1)];

        //添加请求头信息
        $data = $this->httpRequest($url, array('txt' => $message), array(
            'X-Requested-With:XMLHttpRequest',
            'Host:www.niurenqushi.com'
        ), $user_agent);
        if ( $data['code'] == 100000){
            return $data['text'];
        }
        return false;
    }

    private function checkSignature(){

    }

    public function getMessage(){

    }
}
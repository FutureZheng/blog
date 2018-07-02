<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 13:42
 */
namespace App\Http\Library;

use Illuminate\Support\Facades\Redis;


class WechatLibrary {

    private $appid;
    private $secret;
    private static $_instance;


    /**
     * WechatLibrary constructor.
     */
    private function __construct(){
        $wechat = config('wechat');

        $this->appid = $wechat['APPID'];
        $this->secret = $wechat['SECRET'];
    }

    /**
     * @return WechatLibrary
     */
    public static function getInstance(){
        if ( self::$_instance instanceof self){
            return self::$_instance;
        }
        self::$_instance = new self();
        return self::$_instance;
    }

    public function getMessage(){
        $token = $this->getAccessToken();
        
    }

    /**
     * 获取微信token
     * @return bool
     */
    private function getAccessToken(){
        $key = json_encode(array('appId' => $this->appid, 'secret' => $this->secret));

        //判断文件的创建时间
        if ( Redis::exists($key) ){
            return Redis::get($key);
        }
        //判断当前token是否已经失效
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret;
        $data = self::httpRequest($url);

        //保存到redis里面，并且设置国企时间
        Redis::setex($key, 7000, $data['access_token']);

        return $data['access_token'];
    }

    /**
     * 全局的curl请求方法
     * @param $url
     * @param array $data
     * @return bool
     */
    private static function httpRequest($url, $data = array()){
        if ( !$url ){
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TRANSFERTEXT, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, CURLOPT_TIMEOUT);         //设置curl超时时间
        if (strpos($url, 'https' == 0)){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ( $data ){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ( $error ){
            logger(json_encode(array('code' => curl_errno($ch), 'error' => $error)));     //记录错误信息
            return false;
        }
        return json_decode($result, true);
    }
}
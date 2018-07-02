<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 全局的curl请求方法
     * @param $url
     * @param array $data
     * @param array $headers
     * @param string $user_agent
     * @return bool|mixed
     */
    public function httpRequest($url, $data = array(), $headers = array(), $user_agent = ''){
        if ( !$url ){
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TRANSFERTEXT, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, CURLOPT_TIMEOUT);         //设置curl超时时间

        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        //判断如果是http请求，则放弃验
        if ( strpos($url, 'https') == 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        }
        if ( $data ){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        if ( $headers ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if ( $user_agent ){
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        }

        //获取请求头信息
//        $info = curl_getinfo($ch);
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

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * 全局的辅助函数
 * Date: 2017/11/14
 * Time: 16:00
 */

/**
 * 获取指定时间戳的格式化时间
 * @param null $timestamp
 * @return false|string\
 */
function get_time($timestamp = null){
    if ( is_null($timestamp) ){
        return date('Y-m-d H:i:s', time());
    }
    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * 自己的打印函数
 * @param $data
 * @param bool $isDump
 * @param bool $isExit
 */
function get_print( $data, $isDump = false, $isExit = true ){
    echo '<pre>';$isDump ? dump($data) : print_r($data);echo '</pre>';$isExit and exit();
}

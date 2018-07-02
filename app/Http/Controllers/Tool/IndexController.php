<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 14:47
 */
namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller{


    public function chat(){
        return view('tool.chat');
    }

    /**
     * 文件的首页信息
     */
    public function index(){
        $files = array_filter(Storage::disk('logs')->allFiles(), function ($value){
            if ( strpos($value,'.') == 0){
                return false;
            }
            return true;
        });     //过滤掉隐藏文件

        arsort ($files);
        return view('tool.index', [
            'files' => $files
        ]);
    }

    /**
     * 记录请求的参数，请求的url
     * @param Request $request
     */
    public function send(Request $request){

    }

    /**
     * 显示日志的内容
     * @param string $file  文件名
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getFileContent($file){

        //判断文件是否存在
        $exists = Storage::disk('logs')->exists($file);
        if ( !$exists ){
            return back()->with(['message' => '文件不存在']);
        }

        $fileContent = Storage::disk('logs')->get($file);
        echo '<pre>';print_r($fileContent);die;
    }
}
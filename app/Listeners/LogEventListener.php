<?php

namespace App\Listeners;

use App\Events\LogEvent;
use Illuminate\Http\Request;

class LogEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Handle the event.
     * 处理事件监听
     * @param  LogEvent  $event
     * @return void
     */
    public function handle(LogEvent $event){
        //获取请求信息
        $request = $event->request;
        $this->recordLog($request);
    }

    /**
     * @param Request $request
     * 获取所有相关的请求的参数，记录日志信息
     */
    private function recordLog($request){
        $message = [
            'protocol' => $request->getScheme(),
            'host' => $request->getHttpHost(),
            'ip'   => $request->getClientIp(),
            'method' => $request->getMethod(),
            'uri' => $request->getPathInfo(),
            'request' => $request->all()
         ];
        //记录日志信息
        logger(json_encode($message));
    }
}

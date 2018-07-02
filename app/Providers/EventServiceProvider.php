<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],      //系统自带的监听方式
        'App\Events\LogEvent' => [
            'App\Listeners\LogEventListener',
        ],      //定义日志监听
    ];

    /**
     * Register any events for your application.
     * 手动注册事件监听
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

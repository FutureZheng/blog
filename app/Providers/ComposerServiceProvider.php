<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * 绑定服务容器
     * @return void
     */
    public function boot()
    {
        View::composer('home.common.footer', 'App\Http\ViewComposers\FooterComposer');
    }

    /**
     * Register the application services.
     * 注册服务提供者
     * @return void
     */
    public function register()
    {
        //
    }
}

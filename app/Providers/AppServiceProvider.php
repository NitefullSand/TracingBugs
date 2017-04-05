<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 设置数据库string类型默认长度
        Schema::defaultStringLength(191);
        // 设置carbon时间本地化
        \Carbon\Carbon::setLocale('zh');
        // 设置时区为中国
        date_default_timezone_set("PRC");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

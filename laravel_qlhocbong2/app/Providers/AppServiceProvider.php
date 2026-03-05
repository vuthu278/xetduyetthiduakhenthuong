<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Đặt timezone mặc định cho PHP theo cấu hình Laravel
        date_default_timezone_set(config('app.timezone', 'Asia/Ho_Chi_Minh'));
    }
}

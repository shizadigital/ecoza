<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// use Laravel\Passport\Passport; 
// use Illuminate\Support\Facades\URL;

// use Illuminate\Support\Facades\Gate; 
// use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        // $this->registerPolicies(); 
        // Passport::routes();
        // if(env('FORCE_HTTPS')) {
        //     URL::forceScheme('https');
        // }
        
        date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Jakarta'));
        Schema::defaultStringLength(191);
    }
}

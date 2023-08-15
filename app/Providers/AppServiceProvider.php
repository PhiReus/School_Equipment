<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/* DeviceService */
use App\Services\Interfaces\DeviceServiceInterface;
use App\Services\DeviceService;

/* DeviceRepository */
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use App\Repositories\Eloquents\DeviceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */ 
    public function register()
    {
        
        //   Binding Services
        $this->app->singleton(DeviceServiceInterface::class, DeviceService::class);


        
        /* Binding Repositories*/
        $this->app->singleton(DeviceRepositoryInterface::class, DeviceRepository::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
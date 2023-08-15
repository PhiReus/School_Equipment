<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Group
use App\Repositories\Eloquents\GroupRepository;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Services\GroupService;
use App\Services\Interfaces\GroupServiceInterface;

// Device
use App\Services\Interfaces\DeviceServiceInterface;
use App\Services\DeviceService;
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
        // Device
        $this->app->singleton(DeviceServiceInterface::class, DeviceService::class);
        $this->app->singleton(DeviceRepositoryInterface::class, DeviceRepository::class);
        
        // Group
        $this->app->singleton(GroupServiceInterface::class, GroupService::class);
        $this->app->singleton(GroupRepositoryInterface::class, GroupRepository::class);
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
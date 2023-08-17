<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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


// Room
use App\Repositories\Eloquents\RoomRepository;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Services\RoomService;
use App\Services\Interfaces\RoomServiceInterface;


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

        // Rooms
        $this->app->singleton(RoomServiceInterface::class, RoomService::class);
        $this->app->singleton(RoomRepositoryInterface::class, RoomRepository::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

// Group
use App\Repositories\Eloquents\GroupRepository;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Services\GroupService;
use App\Services\Interfaces\GroupServiceInterface;

//User
use App\Repositories\Eloquents\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserService;
use App\Repositories\Interfaces\UserRepositoryInterface;

//Role
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\RoleService;
use App\Services\Interfaces\RoleServiceInterface;

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

// Borrow
use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\BorrowService;
use App\Repositories\Interfaces\BorrowRepositoryInterface;
use App\Repositories\Eloquents\BorrowRepository;

// BorrowDevice
use App\Services\Interfaces\BorrowDeviceServiceInterface;
use App\Services\BorrowDeviceService;
use App\Repositories\Interfaces\BorrowDeviceRepositoryInterface;
use App\Repositories\Eloquents\BorrowDeviceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */ 
    public function register()
    {
       
        //User
        $this->app->singleton(UserServiceInterface::class, UserService::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
      
        //Role
        $this->app->singleton(RoleServiceInterface::class, RoleService::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
      
        // Device
        $this->app->singleton(DeviceServiceInterface::class, DeviceService::class);
        $this->app->singleton(DeviceRepositoryInterface::class, DeviceRepository::class);
        
        // Group
        $this->app->singleton(GroupServiceInterface::class, GroupService::class);
        $this->app->singleton(GroupRepositoryInterface::class, GroupRepository::class);

        // Rooms
        $this->app->singleton(RoomServiceInterface::class, RoomService::class);
        $this->app->singleton(RoomRepositoryInterface::class, RoomRepository::class);

        // Borrows
        $this->app->singleton(BorrowServiceInterface::class, BorrowService::class);
        $this->app->singleton(BorrowRepositoryInterface::class, BorrowRepository::class);

         // BorrowsDevice
         $this->app->singleton(BorrowDeviceServiceInterface::class, BorrowDeviceService::class);
         $this->app->singleton(BorrowDeviceRepositoryInterface::class, BorrowDeviceRepository::class);
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
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
// Group
use App\Repositories\Eloquents\GroupRepository;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Services\GroupService;
use App\Services\Interfaces\GroupServiceInterface;


// Room
use App\Repositories\Eloquents\RoomRepository;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Services\RoomService;
use App\Services\Interfaces\RoomServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->singleton(GroupServiceInterface::class, GroupService::class);

        // /* Binding Repositories*/
        // $this->app->singleton(GroupRepositoryInterface::class, GroupRepository::class);

        // Rooms
            $this->app->singleton(RoomServiceInterface::class, RoomService::class);

            /* Binding Repositories*/
            $this->app->singleton(RoomRepositoryInterface::class, RoomRepository::class);
            
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}

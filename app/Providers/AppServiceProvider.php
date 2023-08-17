<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
//Paginate
use Illuminate\Pagination\Paginator;
//Role
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\RoleService;
use App\Services\Interfaces\RoleServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GroupServiceInterface::class, GroupService::class);
        $this->app->singleton(UserServiceInterface::class, UserService::class);
        $this->app->singleton(RoleServiceInterface::class, RoleService::class);



        /* Binding Repositories*/
        $this->app->singleton(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
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

<?php

namespace App\Providers;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Room;
use App\Policies\DevicePolicy;
use App\Policies\DeviceTypePolicy;
use App\Policies\RoomPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Device::class => DevicePolicy::class,
        DeviceType::class => DeviceTypePolicy::class,
        Room::class => RoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }
}

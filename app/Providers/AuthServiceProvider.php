<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Desk;
use App\Policies\AllowAllPolicy;
use App\Policies\DeskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // ...
        Desk::class => DeskPolicy::class,
        Desk::class => AllowAllPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

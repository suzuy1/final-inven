<?php

namespace App\Providers;

use App\Models\Disposal;
use App\Models\Procurement;
use App\Policies\DisposalPolicy;
use App\Policies\ProcurementPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Policies
        Gate::policy(Procurement::class, ProcurementPolicy::class);
        Gate::policy(Disposal::class, DisposalPolicy::class);
    }
}


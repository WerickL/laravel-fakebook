<?php

namespace App\Providers;

use Api\User\Model\User;
use Api\User\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        Passport::tokensExpireIn(now()->addHours(8));
        Passport::enablePasswordGrant();
        Gate::guessPolicyNamesUsing(function (string $modelClass) {
            return 'Api\\'. class_basename($modelClass). '\\Policies\\' . class_basename($modelClass) . 'Policy';
        });
        //Gate::policy(User::class, UserPolicy::class);
    }
}

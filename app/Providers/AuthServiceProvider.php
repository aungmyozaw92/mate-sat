<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Models\BankInformation;
use Illuminate\Support\Facades\Gate;
use App\Policies\BankInformationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        // BankInformation::class => BankInformationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensCan([
            'agent' => 'agent Type'
        ]);
    }
}

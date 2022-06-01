<?php

namespace App\Providers;

use App\User;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //  Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
        //     $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
        //     if (in_array($type, $parameters)) {
        //         return true;
        //     }
        //     return false;
        // });

        // Validator::replacer('image64', function($message, $attribute, $rule, $parameters) {
        //     return str_replace(':values',join(",",$parameters),$message);
        // });
        /**
         * Laravel Telescope
         */
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }

        /**
         * Store custom sender type in pickup tables
         */
        Relation::morphMap([
            'User' => User::class,
            
        ]);

        /**Password Route */
        Passport::routes();
    }
}

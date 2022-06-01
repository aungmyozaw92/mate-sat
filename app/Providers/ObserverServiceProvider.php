<?php

namespace App\Providers;

use App\User;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Observers\SaleObserver;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;
use App\Observers\CustomerObserver;
use App\Observers\OrderItemObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
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
        User::observe(UserObserver::class);
        Customer::observe(CustomerObserver::class);
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Sale::observe(SaleObserver::class);
    }
}

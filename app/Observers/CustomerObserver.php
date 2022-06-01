<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Arr;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        $customer_id = 0;
        if (Customer::withTrashed()->count()) {
            $customer_id  = Customer::withTrashed()->count(); 
        }else{
            $customer_id += 1;
        }
        
        $customer->customer_no = $customer_id;
        $customer->save();
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        // $changes = $customer->getChanges();
        // $changes = Arr::only($changes, ['email_verified_at']);
        // if ($changes) {
        //     $customer->created_at = now();
        //     $customer->save();
        // }
    }

    /**
     * Handle the Customer "deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}

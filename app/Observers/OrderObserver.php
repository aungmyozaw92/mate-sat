<?php

namespace App\Observers;

use App\User;
use App\Models\Order;
use Illuminate\Support\Arr;
use App\Models\OrderHistory;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $order_id = 0;
        if (Order::withTrashed()->count()) {
            $order_id  = Order::withTrashed()->count(); 
        }else{
            $order_id += 1;
        }
        
        $order->order_no = $order_id;
        $order->save();
        $order->refresh();

        $logStatusId = getStatusId('new_order');
        OrderHistory::create([
            'order_id' => $order->id,
            'log_status_id' => $logStatusId,
            'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        ]);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->wasChanged('order_no') && $order->getOriginal('order_no') == null) {
            return;
        }
        $changed_columns = $order->getChanges();
        $expected_columns = [
            'note',
            'customer_name',
            'total_overall_discount'
        ];
        
        $changes = Arr::only($changed_columns, $expected_columns);
        
        if (empty($changes)) return;
        $transformedInputs = [];
        foreach ($changes as $key => $value) {
            $previous = $order->getOriginal($key);
            $next = $value;
            $transformedInputs[] = transformedOrdersAttribute($key, $previous, $next);
        }

        foreach ($transformedInputs as $key => $value) {
            $logStatusId = getStatusId($value['status']);
                $order_history = OrderHistory::create([
                    'order_id' => $order->id,
                    'log_status_id' => $logStatusId,
                    'previous' => $value['previous'],
                    'next' => $value['next'],
                    'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
                ]);
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        $logStatusId = getStatusId('delete_order');

        OrderHistory::create([
            'order_id' => $order->id,
            'log_status_id' => $logStatusId,
            'previous' => $order->order_no,
            'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        ]);
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}

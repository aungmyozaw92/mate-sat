<?php

namespace App\Observers;

use App\User;
use App\Models\OrderItem;
use Illuminate\Support\Arr;
use App\Models\OrderHistory;
use App\Models\OrderItemHistory;

class OrderItemObserver
{
    /**
     * Handle the OrderItem "created" event.
     *
     * @param  \App\OrderItem  $order_item
     * @return void
     */
    public function created(OrderItem $order_item)
    {
       
        $logStatusId = getStatusId('new_order_item');
        OrderHistory::create([
            'order_id' => $order_item->order_id,
            'log_status_id' => $logStatusId,
            'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        ]);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\OrderItem  $order_item
     * @return void
     */
    public function updated(OrderItem $order_item)
    {
        $changed_columns = $order_item->getChanges();
        $expected_columns = [
            'product_name',
            'qty',
            'discount_amount'
        ];
        
        $changes = Arr::only($changed_columns, $expected_columns);
        
        if (empty($changes)) return;
        $transformedInputs = [];
        foreach ($changes as $key => $value) {
            $previous = $order_item->getOriginal($key);
            $next = $value;
            $transformedInputs[] = transformedOrderItemsAttribute($key, $previous, $next);
        }
        foreach ($transformedInputs as $key => $value) {
         
            $logStatusId = getStatusId($value['status']);
                $order_item_history = OrderHistory::create([
                    'order_id' => $order_item->order_id,
                    'log_status_id' => $logStatusId,
                    'previous' => $value['previous'],
                    'next' => $value['next'],
                    'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
                ]);
        }
    }

    /**
     * Handle the OrderItem "deleted" event.
     *
     * @param  \App\OrderItem  $order_item
     * @return void
     */
    public function deleted(OrderItem $order_item)
    {
        $logStatusId = getStatusId('delete_order_item');

        OrderHistory::create([
            'order_id' => $order_item->order_id,
            'log_status_id' => $logStatusId,
            'previous' => $order_item->order_no,
            'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        ]);
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\OrderItem  $order_item
     * @return void
     */
    public function restored(OrderItem $order_item)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\OrderItem  $order_item
     * @return void
     */
    public function forceDeleted(OrderItem $order_item)
    {
        //
    }
}

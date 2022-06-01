<?php

namespace App\Observers;

use App\User;
use App\Models\Sale;
use Illuminate\Support\Arr;
use App\Models\SaleHistory;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     *
     * @param  \App\Sale  $sale
     * @return void
     */
    public function created(Sale $sale)
    {
        $sale_id = 0;
        if (Sale::withTrashed()->count()) {
            $sale_id  = Sale::withTrashed()->count(); 
        }else{
            $sale_id += 1;
        }
        
        $sale->invoice_no = $sale_id;
        $sale->save();
        $sale->refresh();

        // $logStatusId = getStatusId('new_sale');
        // SaleHistory::create([
        //     'sale_id' => $sale->id,
        //     'log_status_id' => $logStatusId,
        //     'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        // ]);
    }

    /**
     * Handle the Sale "updated" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function updated(Sale $sale)
    {
        // if ($sale->wasChanged('invoice_no') && $sale->getOriginal('invoice_no') == null) {
        //     return;
        // }
        // $changed_columns = $sale->getChanges();
        // $expected_columns = [
        //     'note',
        //     'customer_name',
        //     'total_overall_discount'
        // ];
        
        // $changes = Arr::only($changed_columns, $expected_columns);
        
        // if (empty($changes)) return;
        // $transformedInputs = [];
        // foreach ($changes as $key => $value) {
        //     $previous = $sale->getOriginal($key);
        //     $next = $value;
        //     $transformedInputs[] = transformedOrdersAttribute($key, $previous, $next);
        // }

        // foreach ($transformedInputs as $key => $value) {
        //     $logStatusId = getStatusId($value['status']);
        //         $sale_history = SaleHistory::create([
        //             'sale_id' => $sale->id,
        //             'log_status_id' => $logStatusId,
        //             'previous' => $value['previous'],
        //             'next' => $value['next'],
        //             'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        //         ]);
        // }
    }

    /**
     * Handle the Sale "deleted" event.
     *
     * @param  \App\Sale  $sale
     * @return void
     */
    public function deleted(Sale $sale)
    {
        // $logStatusId = getStatusId('delete_sale');

        // SaleHistory::create([
        //     'order_id' => $sale->id,
        //     'log_status_id' => $logStatusId,
        //     'previous' => $sale->invoice_no,
        //     'created_by' => isset(auth()->user()->id) ? auth()->user()->id : User::orderBy('created_at','asc')->first()
        // ]);
    }

    /**
     * Handle the Sale "restored" event.
     *
     * @param  \App\Sale  $sale
     * @return void
     */
    public function restored(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     *
     * @param  \App\Sale  $sale
     * @return void
     */
    public function forceDeleted(Sale $sale)
    {
        //
    }
}

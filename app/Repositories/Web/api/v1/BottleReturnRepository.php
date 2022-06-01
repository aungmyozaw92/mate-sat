<?php

namespace App\Repositories\Web\api\v1;

use App\Models\BottleReturn;
use App\Models\BottleReturnHistory;
use App\Repositories\BaseRepository;

class BottleReturnRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return BottleReturn::class;
    }

    public function getBottleReturns()
    {
        $result = BottleReturn::filter(request()->all())
                            ->with(['sale','customer','product','bottle_return_histories','created_user'])
                            ->orderBy('created_at','asc');
         if (request()->has('paginate')) {
            $result = $result->paginate(request()->get('paginate'));
        } else {
            $result = $result->get();
        }
        return $result;
    }

    /**
     * @param array $data
     *
     * @return BottleReturn
     */
    public function create($sale_item)
    {
        $bottle_return = BottleReturn::create([
            'sale_id' => $sale_item->sale_id,
            'sale_item_id' => $sale_item->id,
            'product_id' => $sale_item->product_id,
            'customer_id' => $sale_item->sale->customer_id,
            'total_bottle' => $sale_item->qty,
            'remain_bottle' => $sale_item->qty,
            'created_by' => auth()->user()->id,
        ]);

        return $bottle_return;
    }

    /**
     * @param BottleReturn  $bottle_return
     * @param array $data
     *
     * @return mixed
     */
    public function update(BottleReturn $bottle_return, array $data) : BottleReturn
    {
        $bottle_return_history = BottleReturnHistory::create([
            'bottle_return_id' => $bottle_return->id,
            'returned_bottle' => $data['returned_bottle'],
            'returned_date' => now(),
            'created_by' => auth()->user()->id,
        ]);

        if ($bottle_return_history->returned_bottle - $bottle_return->remain_bottle == 0) {
            $bottle_return->status = true;
        }
        $bottle_return->remain_bottle = $bottle_return->total_bottle - ($bottle_return_history->returned_bottle + $bottle_return->returned_bottle);
        $bottle_return->returned_bottle += $bottle_return_history->returned_bottle;
        
        
       
        if ($bottle_return->isDirty()) {
            $bottle_return->updated_by = auth()->user()->id;
            $bottle_return->save();
        }
        return $bottle_return->refresh();
    }

    /**
     * @param BottleReturn $bottle_return
     */
    public function destroy(BottleReturn $bottle_return)
    {
        $deleted = $this->deleteById($bottle_return->id);

        if ($deleted) {
            // $bottle_return->deleted_by_id = auth()->user()->id;
            // $bottle_return->deleted_by_type = class_basename(auth()->user()->getModel());
            $bottle_return->save();
        }
    }
}

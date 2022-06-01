<?php

namespace App\Repositories\Web\api\v1;

use App\Models\SaleItem;
use App\Repositories\BaseRepository;

class SaleItemRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return SaleItem::class;
    }

    /**
     * @param array $data
     *
     * @return SaleItem
     */
    public function create($order_item)
    {
        $sale_item = SaleItem::create([
            'product_id' => $order_item['product_id'],
            'sale_id' => $order_item['sale_id'],
            'product_name' => $order_item['product_name'],
            'product_item_code' => $order_item['product_item_code'],
            'qty' => $order_item['qty'],
            'price' => $order_item['price'],
            'discount_amount' => $order_item['discount_amount'],
            'amount' => $order_item['amount'],
            'created_by' => auth()->user()->id,
        ]);

        if($sale_item->product->exclusive_bottle){
            $bottleReturnRepository = new BottleReturnRepository();
            $result = $bottleReturnRepository->create($sale_item);
        }
        return $sale_item->refresh();
    }

}

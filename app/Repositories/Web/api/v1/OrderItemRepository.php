<?php

namespace App\Repositories\Web\api\v1;

use App\Models\OrderItem;
use App\Repositories\BaseRepository;

class OrderItemRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return OrderItem::class;
    }

    public function getOrderItems()
    {
        $order_items = OrderItem::with(['product'])->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $order_items = $order_items->paginate(request()->get('paginate'));
        } else {
            $order_items = $order_items->get();
        }
        return $order_items;
    }

    /**
     * @param array $data
     *
     * @return OrderItem
     */
    public function create(array $data) : OrderItem
    {
        $order_item = OrderItem::create([
            'product_id' => $data['product_id'],
            'order_id' => $data['order_id'],
            'product_name' => $data['product_name'],
            'product_item_code' => $data['product_item_code'],
            'qty' => $data['qty'],
            'price' => $data['price'],
            'discount_amount' => $data['discount_amount'],
            'amount' => ($data['qty'] * $data['price']),
            'created_by' => auth()->user()->id,
        ]);

        return $order_item->refresh();
    }

    /**
     * @param OrderItem  $order_item
     * @param array $data
     *
     * @return mixed
     */
    public function update(OrderItem $order_item, array $data) : OrderItem
    {
        $order_item->product_id = isset($data['product_id']) ? $data['product_id'] : $order_item->product_id;
        $order_item->product_name = isset($data['product_name']) ? $data['product_name'] : $order_item->product_name;
        $order_item->product_item_code = isset($data['product_item_code']) ? $data['product_item_code'] : $order_item->product_item_code;
        $order_item->qty = isset($data['qty']) ? $data['qty'] : $order_item->qty;
        $order_item->price = isset($data['price']) ? $data['price'] : $order_item->price;
        $order_item->discount_amount = isset($data['discount_amount']) ? $data['discount_amount'] : $order_item->discount_amount;
        $order_item->amount = (isset($data['qty']) && isset($data['price'])) ? $data['qty'] * $data['price'] : $order_item->amount;
       
        if ($order_item->isDirty()) {
            $order_item->updated_by = auth()->user()->id;
            $order_item->save();
        }
        return $order_item->refresh();
    }

    /**
     * @param OrderItem $order_item
     */
    public function destroy(OrderItem $order_item)
    {
        $deleted = $this->deleteById($order_item->id);

        if ($deleted) {
            $order_item->deleted_by = auth()->user()->id;
            // $order_item->deleted_by_type = class_basename(auth()->user()->getModel());
            $order_item->save();
        }
    }
}

<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Repositories\BaseRepository;
use App\Repositories\Web\api\v1\OrderItemRepository;

class OrderRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    public function getOrders()
    {
        $orders = Order::filter(request()->all())->with(['customer','order_items'])->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $orders = $orders->paginate(request()->get('paginate'));
        } else {
            $orders = $orders->get();
        }
        return $orders;
    }

    public function getCustomerOrders($customer)
    {
        $orders = Order::where('customer_id',$customer->id)
                    ->filter(request()->all())
                    ->with(['order_items'])
                    ->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $orders = $orders->paginate(request()->get('paginate'));
        } else {
            $orders = $orders->get();
        }
        return $orders;
    }

    /**
     * @param array $data
     *
     * @return Order
     */
    public function create(array $data) : Order
    {
        $customer = Customer::findOrFail($data['customer_id']);
        $order = Order::create([
            'customer_id'   => $data['customer_id'],
            'customer_name'   => $customer->name,
            'customer_phone'   => $customer->phone,
            'customer_address'   => $customer->address,
            'customer_city_name'   => $customer->city->name,
            'customer_zone_name'   => $customer->zone->name,
            'status'   => isset($data['status']) ? $data['status'] : false,
            'type'   => isset($data['type']) ? $data['type'] : null,
            'note'   => isset($data['note']) ? $data['note'] : null,
            'delivery_address'   => isset($data['delivery_address']) ? $data['delivery_address'] : null,
            'total_overall_discount'   => isset($data['total_overall_discount']) ? $data['total_overall_discount'] : 0,
            'created_by' => auth()->user()->id,
        ]);

        if (isset($data['order_items']) && $data['order_items']) {
            $orderItemRepository = new OrderItemRepository();
            $total_qty = 0;
            $total_price = 0;
            $total_amount = 0;
            $total_product_discount = 0;
            foreach ($data['order_items'] as $key => $item) {
                $item['order_id'] = $order->id;
                $order_item = $orderItemRepository->create($item);
                $total_qty += $order_item->qty;
                $total_price += $order_item->price;
                $total_amount += $order_item->amount;
                $total_product_discount += $order_item->discount_amount;
            }
        }

        $order->total_qty = $total_qty;
        $order->total_price = $total_price;
        $order->total_amount = $total_amount;
        $order->total_product_discount = $total_product_discount;
        $order->grand_total_amount = $total_amount - $total_product_discount - $order->total_overall_discount;
        
        if ($order->isDirty()) {
            $order->save();

            $customer->order_count += 1;
            $customer->save();
        }

        return $order->refresh();
    }

    /**
     * @param Order  $order
     * @param array $data
     *
     * @return mixed
     */
    public function update(Order $order, array $data) : Order
    {
        if (isset($data['customer_id']) && $data['customer_id']) {
            $customer = Customer::findOrFail($data['customer_id']);
        }

        if (isset($data['total_overall_discount'])) {
           $grand_total =  $order->total_amount - $order->total_product_discount - $data['total_overall_discount'] ;
        }
        
        $order->customer_id = isset($data['customer_id']) ? $data['customer_id'] : $order->customer_id;
        $order->note = isset($data['note']) ? $data['note'] : $order->note;
        $order->delivery_address = isset($data['delivery_address']) ? $data['delivery_address'] : $order->delivery_address;
        $order->customer_name = isset($data['customer_id']) ? $customer->name : $order->customer_name;
        $order->customer_phone = isset($data['customer_id']) ? $customer->phone : $order->customer_phone;
        $order->customer_address = isset($data['customer_id']) ? $customer->address : $order->customer_address;
        $order->customer_city_name = isset($data['customer_id']) ? $customer->city->name : $order->customer_city_name;
        $order->customer_zone_name = isset($data['customer_id']) ? $customer->zone->name : $order->customer_zone_name;
        $order->total_overall_discount = isset($data['total_overall_discount']) ? $data['total_overall_discount'] : $order->total_overall_discount;
        $order->grand_total_amount = isset($data['total_overall_discount']) ? $grand_total : $order->grand_total_amount;
       
        if ($order->isDirty()) {
            $order->updated_by = auth()->user()->id;
            $order->save();
        }
        return $order->refresh();
    }

    /**
     * @param Order  $order
     * @param array $data
     *
     * @return mixed
     */
    public function update_order_amount(OrderItem $order_item , $type)
    {
        $order = $order_item->order;

        if($type === 'add'){
            $order->total_qty += $order_item->qty;;
            $order->total_price += $order_item->price;
            $order->total_amount += $order_item->amount;
            $order->total_product_discount += $order_item->discount_amount;;
            $order->grand_total_amount += $order_item->amount - $order_item->discount_amount ;
        }elseif ($type === 'update') {
            
            $total_qty = 0;
            $total_price = 0;
            $total_amount = 0;
            $total_product_discount = 0;
            foreach ($order->order_items as $key => $item) {
                $total_qty += $item->qty;
                $total_price += $item->price;
                $total_amount += $item->amount;
                $total_product_discount += $item->discount_amount;
            }
            $order->total_qty = $total_qty;
            $order->total_price = $total_price;
            $order->total_amount = $total_amount;
            $order->total_product_discount = $total_product_discount;
            $order->grand_total_amount = $total_amount - $total_product_discount - $order->total_overall_discount;
            
        }else{
            $order->total_qty -= $order_item->qty;;
            $order->total_price -= $order_item->price;
            $order->total_amount -= $order_item->amount;
            $order->total_product_discount -= $order_item->discount_amount;;
            $order->grand_total_amount -= $order_item->amount - $order_item->discount_amount ;
        }
        
        if ($order->isDirty()) {
            $order->save();
        }

        return $order->refresh();
    }

    /**
     * @param Order $order
     */
    public function destroy(Order $order)
    {
        $customer = $order->customer;
        $deleted = $this->deleteById($order->id);

        if ($deleted) {
            $order->deleted_by = auth()->user()->id;
            // $order->deleted_by_type = class_basename(auth()->user()->getModel());
            $order->save();

            $customer->order_count -= 1;
            $customer->save();
        }
    }
}

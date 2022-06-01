<?php

namespace App\Services\Interfaces;

use App\Models\OrderItem;

interface OrderItemServiceInterface
{
    public function create(array $data);
    public function update(OrderItem $order_item,array $data);
    public function destroy(OrderItem $order_item);
}
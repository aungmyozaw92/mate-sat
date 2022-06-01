<?php

namespace App\Services\Interfaces;

use App\Models\Order;

interface OrderServiceInterface
{
    public function getOrders();
    public function getOrder($id);
    public function create(array $data);
    public function update(Order $order,array $data);
    public function destroy(Order $order);
}
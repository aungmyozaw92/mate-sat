<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Order;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\OrderRepository;
use App\Repositories\Web\api\v1\AccountRepository;
use App\Services\Interfaces\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrders()
    {
        return $this->orderRepository->getOrders();
    }

    public function getOrder($id)
    {
        return $this->orderRepository->getById($id);
    }
    
    public function create(array $data)
    {       
        DB::beginTransaction();
        try {
            $order = $this->orderRepository->create($data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create Order');
        }
        DB::commit();

        return $order;
    }

    public function update(Order $order,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->orderRepository->update($order, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Order');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            $result = $this->orderRepository->destroy($order);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Order');
        }
        DB::commit();
        
        return $result;
    }

}
<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\OrderItem;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\OrderRepository;
use App\Repositories\Web\api\v1\OrderItemRepository;
use App\Services\Interfaces\OrderItemServiceInterface;

class OrderItemService implements OrderItemServiceInterface
{
    protected $orderItemRepository;
    protected $orderRepository;

    public function __construct(
        OrderItemRepository $orderItemRepository,
        OrderRepository $orderRepository
    )
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
    }
    
    public function create(array $data)
    {       
        DB::beginTransaction();
        try {
            $orderItem = $this->orderItemRepository->create($data);
            if($orderItem){
                $this->orderRepository->update_order_amount($orderItem, 'add');
            }
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create OrderItem');
        }
        DB::commit();

        return $orderItem;
    }

    public function update(OrderItem $orderItem,array $data)
    {
        // DB::beginTransaction();
        // try {
            $result = $this->orderItemRepository->update($orderItem, $data);
            if($orderItem){
                $this->orderRepository->update_order_amount($orderItem, 'update');
            }
        // }
        // catch(Exception $exc){
        //     DB::rollBack();
        //     Log::error($exc->getMessage());
        //     throw new InvalidArgumentException('Unable to update OrderItem');
        // }
        // DB::commit();

        return $result;
    }

    public function destroy(OrderItem $orderItem)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderRepository->update_order_amount($orderItem, 'delete');
           
            if ($order) {
                $result = $this->orderItemRepository->destroy($orderItem);
            }
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete OrderItem');
        }
        DB::commit();
        
        return $result;
    }

}
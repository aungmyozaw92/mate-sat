<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\OrderService;
use App\Services\Web\api\v1\OrderItemService;
use App\Http\Requests\Web\OrderItem\CreateOrderItemRequest;
use App\Http\Requests\Web\OrderItem\UpdateOrderItemRequest;
use App\Http\Resources\Web\api\v1\OrderItem\OrderItemResource;

class OrderItemController extends Controller
{
    /**
     * @var OrderItemService
     */
    protected $orderItemService;
    protected $orderService;

    /**
     * AgentController constructor.
     *
     * @param OrderItemService $orderItemService
     */
    public function __construct(OrderItemService $orderItemService,
                                OrderService $orderService
                                )
    {
        $this->orderItemService = $orderItemService;
        $this->orderService = $orderService;
        // $this->middleware('permission:order_item-list|order_item-create|order_item-edit|order_item-delete', ['only' => ['index','show']]);
        $this->middleware('permission:order_item-create', ['only' => ['create','store']]);
        $this->middleware('permission:order_item-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order_item-delete', ['only' => ['destroy']]);
    }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     $order_items = $this->orderItemService->getAllOrderItems();
    //     return new OrderItemCollection($order_items);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderItemRequest $request)
    {
        $order = $this->orderService->getOrder($request['order_id']);
        if ($order->status) {
            return response()->json(['status' => 2,'message' => 'Connot update because order is already sale invoice'], Response::HTTP_OK);
        }
        $orderItem = $this->orderItemService->create($request->all());
        return new OrderItemResource($orderItem);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(OrderItem $orderItem)
    // {
    //     return new OrderItemResource($orderItem->load(['zones']));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $order = $this->orderService->getOrder($orderItem->order_id);
        if ($order->status) {
            return response()->json(['status' => 2,'message' => 'Connot update because order is already sale invoice'], Response::HTTP_OK);
        }
        $this->orderItemService->update($orderItem, $request->all());
        return new OrderItemResource($orderItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        $order = $this->orderService->getOrder($orderItem->order_id);
        if ($order->status) {
            return response()->json(['status' => 2,'message' => 'Connot delete because order is already sale invoice'], Response::HTTP_OK);
        }
        $this->orderItemService->destroy($orderItem);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }
}

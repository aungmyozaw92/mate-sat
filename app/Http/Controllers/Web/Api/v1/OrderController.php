<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Order;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\OrderService;
use App\Http\Requests\Web\Order\CreateOrderRequest;
use App\Http\Requests\Web\Order\UpdateOrderRequest;
use App\Http\Resources\Web\api\v1\Order\OrderResource;
use App\Http\Resources\Web\api\v1\Order\OrderCollection;
use App\Http\Resources\Web\api\v1\OrderHistory\OrderHistoryCollection;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * AgentController constructor.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','show']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderService->getOrders();
        return new OrderCollection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $order = $this->orderService->create($request->all());
        return new OrderResource($order->load(['order_items','customer']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order->load(['order_items','customer']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($order->status) {
            return response()->json(['status' => 2,'message' => 'Connot update because order is already sale invoice'], Response::HTTP_OK);
        }
        $this->orderService->update($order, $request->all());
        return new OrderResource($order->load(['order_items','customer']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->status) {
            return response()->json(['status' => 2,'message' => 'Connot delete because order is already sale invoice'], Response::HTTP_OK);
        }
        $this->orderService->destroy($order);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function histories(Order $order)
    {
        return new OrderHistoryCollection($order->order_histories);
    }
}

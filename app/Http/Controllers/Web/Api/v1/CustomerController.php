<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Customer;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\CustomerService;
use App\Http\Resources\Web\api\v1\Sale\SaleCollection;
use App\Http\Resources\Web\api\v1\Order\OrderCollection;
use App\Http\Requests\Web\Customer\CreateCustomerRequest;
use App\Http\Requests\Web\Customer\UpdateCustomerRequest;
use App\Http\Resources\Web\api\v1\Customer\CustomerResource;
use App\Http\Resources\Web\api\v1\Customer\CustomerCollection;

class CustomerController extends Controller
{
    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * AgentController constructor.
     *
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','show']]);
        $this->middleware('permission:customer-create', ['only' => ['create','store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->customerService->getCustomers();
        return new CustomerCollection($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $customer = $this->customerService->create($request->all());
        return new CustomerResource($customer->load(['city','zone']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer->load([
            'city','zone'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $this->customerService->update($customer, $request->all());
        return new CustomerResource($customer->load(['city','zone']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->customerService->destroy($customer);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrders(Customer $customer)
    {
        $data = $this->customerService->getCustomerOrders($customer);
        return new OrderCollection($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSales(Customer $customer)
    {
        $data = $this->customerService->getCustomerSales($customer);
        return new SaleCollection($data);
    }
}

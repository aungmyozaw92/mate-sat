<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Customer;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\SaleRepository;
use App\Repositories\Web\api\v1\OrderRepository;
use App\Repositories\Web\api\v1\CustomerRepository;
use App\Services\Interfaces\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
    protected $customerRepository;
    protected $orderRepository;
    protected $saleRepository;

    public function __construct(
                            CustomerRepository $customerRepository,
                            OrderRepository $orderRepository,
                            SaleRepository $saleRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
        $this->saleRepository = $saleRepository;
    }

    public function getCustomers()
    {
        return $this->customerRepository->getCustomers();
    }

    public function getCustomer($id)
    {
        return $this->customerRepository->getCustomer($id);
    }

    public function getCustomerOrders($customer)
    {
        return $this->orderRepository->getCustomerOrders($customer);
    }
    
    public function getCustomerSales($customer)
    {
        return $this->saleRepository->getCustomerSales($customer);
    }

    public function getCustomerGroupBy($customer,$type)
    {
        return $customer->customer_groups->pluck($type)->all();
    }

    public function getCheckCustomer($phone_no)
    {
        return $this->customerRepository->getCheckCustomer($phone_no);
    }
    
    public function create(array $data)
    {        
        $result = $this->customerRepository->create($data);

        return $result;
    }

    public function update(Customer $customer,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->customerRepository->update($customer, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update customer');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            $result = $this->customerRepository->destroy($customer);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete customer');
        }
        DB::commit();
        
        return $result;
    }

}
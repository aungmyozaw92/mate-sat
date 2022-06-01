<?php

namespace App\Services\Interfaces;

use App\Models\Customer;

interface CustomerServiceInterface
{
    public function getCustomers();
    public function getCustomer($id);
    public function getCustomerGroupBy(Customer $customer,string $type);
    public function create(array $data);
    public function update(Customer $customer,array $data);
    public function destroy(Customer $customer);
    public function getCustomerOrders(Customer $customer);
    public function getCustomerSales(Customer $customer);
}
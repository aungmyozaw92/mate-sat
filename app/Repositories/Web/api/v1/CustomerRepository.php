<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Customer;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class CustomerRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }

    public function getCustomers()
    {
        $customers = Customer::with(['user','city','zone'])
                    ->filter(request()->only(['search']))
                    ->orderBy('created_at','desc');
        if (request()->has('paginate')) {
            $customers = $customers->paginate(request()->get('paginate'));
        } else {
            $customers = $customers->get();
        }
        return $customers;
    }
    public function getCheckCustomer($phone)
    {
        $customer = Customer::where('phone', $phone)->first();
        return $customer;
    }

    /**
     * @param array $data
     *
     * @return Customer
     */
    public function create(array $data) : Customer
    {
        $customer = Customer::create([
            'membership_no'  => isset($data['membership_no']) ? $data['membership_no'] : null,
            'name'  => $data['name'],
            'phone'  => $data['phone'],
            'another_phone'  => isset($data['another_phone']) ? $data['another_phone'] : null,
            'email'  => isset($data['email']) ? $data['email'] : null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
            'city_id'  => $data['city_id'],
            'zone_id'  => $data['zone_id'],
            'address'  => $data['address'],
            'is_active'  => isset($data['is_active']) ? $data['is_active'] : false,
            'created_by_id' => auth()->user()->id,
            'created_by_type' => class_basename(auth()->user()->getModel())
        ]);

        return $customer;
    }

    /**
     * @param Customer  $customer
     * @param array $data
     *
     * @return mixed
     */
    public function update(Customer $customer, array $data) : Customer
    {
        $customer->membership_no = isset($data['membership_no']) ? $data['membership_no'] : $customer->membership_no ;
        $customer->name = isset($data['name']) ? $data['name'] : $customer->name ;
        $customer->phone = isset($data['phone']) ? $data['phone'] : $customer->phone ;
        $customer->another_phone = isset($data['another_phone']) ? $data['another_phone'] : $customer->another_phone ;
        $customer->email = isset($data['email']) ? $data['email'] : $customer->email ;
        $customer->password = isset($data['password']) ? Hash::make($data['password']) : $customer->password ;
        $customer->city_id = isset($data['city_id']) ? $data['city_id'] : $customer->city_id ;
        $customer->zone_id = isset($data['zone_id']) ? $data['zone_id'] : $customer->zone_id ;
        $customer->address = isset($data['address']) ? $data['address'] : $customer->address ;
        $customer->is_active = isset($data['is_active']) ? $data['is_active'] : $customer->is_active ;
        
        
        if ($customer->isDirty()) {
            $customer->updated_by_id = auth()->user()->id;
            $customer->updated_by_type = class_basename(auth()->user()->getModel());
            $customer->save();
        }
        return $customer->refresh();
    }

    /**
     * @param Customer $customer
     */
    public function destroy(Customer $customer)
    {
        $deleted = $this->deleteById($customer->id);

        if ($deleted) {
            $customer->deleted_by = auth()->user()->id;
            $customer->save();
        }
    }
}

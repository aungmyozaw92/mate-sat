<?php

namespace App\Models;

use App\User;
use App\Models\City;
use App\Models\Zone;
use App\Models\Order;
use App\Models\BottleReturn;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_no',
        'membership_no',
        'name',
        'phone',
        'another_phone',
        'email',
        'password',
        'city_id',
        'zone_id',
        'address',
        'is_active',
        'sale_count',
        'order_count',
        'created_by_type',
        'updated_by_type',
        'created_by_id',
        'updated_by_id',
        'deleted_by',
    ];

     /**
     * Mutators
     */
    public function setCustomerNoAttribute($value)
    {
        $this->attributes['customer_no'] = 'CN' . str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function user(){
        return $this->belongsTo( User::class, 'created_by');
    }

    public function city(){
        return $this->belongsTo( City::class, 'city_id');
    }
    public function zone(){
        return $this->belongsTo( Zone::class, 'zone_id');
    }

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('customer_no', 'ILIKE', "%{$search}%")
                  ->orWhere('name', 'ILIKE', "%{$search}%")
                  ->orWhere('phone', 'ILIKE', "%{$search}%")
                  ->orWhere('another_phone', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
                 
        }
        if (isset($filter['name']) && $name = $filter['name']) {
            $query->where('name', 'ILIKE', "%{$name}%");
        }
        if (isset($filter['email']) && $email = $filter['email']) {
            $query->where('email', 'ILIKE', "%{$email}%");
        }
        if (isset($filter['phone']) && $phone = $filter['phone']) {
            $query->where('phone', 'ILIKE', "%{$phone}%");
        }
        if (isset($filter['another_phone']) && $another_phone = $filter['another_phone']) {
            $query->where('another_phone', 'ILIKE', "%{$another_phone}%");
        }
        if (isset($filter['membership_no']) && $membership_no = $filter['membership_no']) {
            $query->where('membership_no', 'ILIKE', "%{$membership_no}%");
        }
        if (isset($filter['customer_no']) && $customer_no = $filter['customer_no']) {
            $query->where('customer_no', 'ILIKE', "%{$customer_no}%");
        }
        if (isset($filter['address']) && $address = $filter['address']) {
            $query->where('address', 'ILIKE', "%{$address}%");
        }
        if (isset($filter['is_active']) && $is_active = $filter['is_active']) {
            $query->where('is_active', true);
        }
        if (isset($filter['city_id']) && $city_id = $filter['city_id']) {
            $query->where('city_id', $city_id);
        }
        if (isset($filter['zone_id']) && $zone_id = $filter['zone_id']) {
            $query->where('zone_id', $zone_id);
        }
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function bottle_returns()
    {
        return $this->hasMany(BottleReturn::class);
    }


}

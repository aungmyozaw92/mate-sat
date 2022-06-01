<?php

namespace App\Models;

use App\User;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
        'total_qty' => 'integer',
        'total_price' => 'integer',
        'total_amount' => 'integer',
        'total_product_discount' => 'integer',
        'total_overall_discount' => 'integer',
        'grand_total_amount' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_city_name',
        'customer_zone_name',
        'total_qty',
        'total_price',
        'total_amount',
        'total_product_discount',
        'total_overall_discount',
        'grand_total_amount',
        'status',
        'note',
        'type',
        'delivery_address',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

     /**
     * Mutators
     */
    public function setOrderNoAttribute($value)
    {
        $this->attributes['order_no'] = 'O' . str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function scopeFilter($query, $filter)
    {
        
         if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('order_no', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_name', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_address', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_city_name', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_zone_name', 'ILIKE', "%{$search}%");
        }
        if (isset($filter['status']) && $status = $filter['status']) {
            $query->where('status', ($status == 'true') ? true : false);
        }
        if (isset($filter['order_no']) && $order_no = $filter['order_no']) {
            $query->where('order_no', $order_no);
        }
    }

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updated_user(){
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function customer()
    {
        return $this->belongsTo( Customer::class );
    }

    public function order_items()
    {
        return $this->hasMany( OrderItem::class );
    }

     public function order_histories()
    {
        return $this->hasMany( OrderHistory::class )->orderBy('id', "DESC");
    }
}

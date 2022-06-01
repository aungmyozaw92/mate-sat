<?php

namespace App\Models;

use App\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\OrderItem;
use App\Models\SalePayment;
use App\Models\OrderHistory;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sales';

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
        'total_amount' => 'integer',
        'total_discount' => 'integer',
        'grand_total' => 'integer',
        'paid_amount' => 'integer'
    ];
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no',
        'order_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_city_name',
        'customer_zone_name',
        'total_qty',
        'total_amount',
        'total_discount',
        'grand_total',
        'paid_amount',
        'status',
        'payment_status',
        'note',
        'delivery_address',
        'created_by',
        'updated_by',
        'deleted_by',
       
    ];

     /**
     * Mutators
     */
    public function setInvoiceNoAttribute($value)
    {
        $this->attributes['invoice_no'] = 'S-I' . str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function scopeFilter($query, $filter)
    {
         if (isset($filter['from_date']) && $from_date = $filter['from_date']) {
            if (isset($filter['to_date']) && $to_date = $filter['to_date']) {
                ($from_date == $to_date)
                    ? $query->whereDate('created_at', $from_date)
                    : $query->whereBetween('created_at', [$from_date, \Carbon\Carbon::parse($to_date)->addDays(1)]);
            } else {
                $query->whereDate('created_at', $from_date);
            }
        }
        if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('invoice_no', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_name', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_address', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_city_name', 'ILIKE', "%{$search}%")
                  ->orWhere('customer_zone_name', 'ILIKE', "%{$search}%");
        }
        if (isset($filter['order_no']) && $order_no = $filter['order_no']) {
            $query->whereHas('order', function ($q) use($order_no) {
                $q->where('order_no', $order_no);
            });
        }
        if (isset($filter['invoice_no']) && $invoice_no = $filter['invoice_no']) {
            $query->where('invoice_no', $invoice_no);
        }
        if (isset($filter['customer_name']) && $customer_name = $filter['customer_name']) {
            $query->where('customer_name', $customer_name);
        }
        if (isset($filter['customer_phone']) && $customer_phone = $filter['customer_phone']) {
            $query->where('customer_phone', $customer_phone);
        }
        if (isset($filter['customer_city_name']) && $customer_city_name = $filter['customer_city_name']) {
            $query->where('customer_city_name', $customer_city_name);
        }
        if (isset($filter['customer_zone_name']) && $customer_zone_name = $filter['customer_zone_name']) {
            $query->where('customer_zone_name', $customer_zone_name);
        }
        if (isset($filter['status']) && $status = $filter['status']) {
            $query->where('status', $status);
        }
        if (isset($filter['payment_status']) && $payment_status = $filter['payment_status']) {
            $query->where('payment_status', $payment_status);
        }
    }

    public function scopeDailySaleFilter($query, $filter){
        if (isset($filter['from_date']) && $from_date = $filter['from_date']) {
            if (isset($filter['to_date']) && $to_date = $filter['to_date']) {
                ($from_date == $to_date)
                    ? $query->whereDate('created_at', $from_date)
                    : $query->whereBetween('created_at', [$from_date, \Carbon\Carbon::parse($to_date)->addDays(1)]);
            } else {
                $query->whereDate('created_at', $from_date);
            }
        }
    }
    public function scopeCompleteSaleFilter($query, $filter){
        $query->where('status', 'completed')
             ->where('payment_status', 'paid');
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
    public function order()
    {
        return $this->belongsTo( Order::class );
    }

    public function sale_items()
    {
        return $this->hasMany( SaleItem::class );
    }

    public function sale_payments()
    {
        return $this->hasMany( SalePayment::class );
    }

    //  public function order_histories()
    // {
    //     return $this->hasMany( SaleHistory::class )->orderBy('id', "DESC");
    // }
}

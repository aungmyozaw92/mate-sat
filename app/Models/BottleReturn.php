<?php

namespace App\Models;

use App\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\BottleReturnHistory;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BottleReturn extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bottle_returns';

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
        'status' => 'boolean',
        'total_bottle' => 'integer',
        'returned_bottle' => 'integer',
        'remain_bottle' => 'integer',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'sale_item_id',
        'product_id',
        'customer_id',
        'total_bottle',
        'returned_bottle',
        'remain_bottle',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['sale_invoice_no']) && $sale_invoice_no = $filter['sale_invoice_no']) {
            $query->whereHas('sale', function ($q) use($sale_invoice_no) {
                $q->where('invoice_no', $sale_invoice_no);
            });
        }
        if (isset($filter['customer_name']) && $customer_name = $filter['customer_name']) {
            $query->whereHas('customer', function ($q) use($customer_name) {
                $q->where('name', 'like', "%{$customer_name}%");
            });
        }
        if (isset($filter['product_name']) && $product_name = $filter['product_name']) {
            $query->whereHas('product', function ($q) use($product_name) {
                $q->where('name', 'like', "%{$product_name}%");
            });
        }
        if (isset($filter['status']) && $status = $filter['status']) {
            $query->where('status', $status);
        }
    }

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by');
    }
    public function sale(){
        return $this->belongsTo( Sale::class);
    }
    public function sale_item(){
        return $this->belongsTo( SaleItem::class);
    }
    public function product(){
        return $this->belongsTo( Product::class);
    }
    public function customer(){
        return $this->belongsTo( Customer::class);
    }
    public function bottle_return_histories(){
        return $this->hasMany( BottleReturnHistory::class);
    }
}

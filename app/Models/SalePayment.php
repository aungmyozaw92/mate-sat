<?php

namespace App\Models;

use App\User;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalePayment extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sale_payments';

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
        'payment_amount' => 'integer',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'payment_method',
        'payment_amount',
        'payment_reference',
        // 'payment_status',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function scopeFilter($query, $filter)
    {
         if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('sale_id', 'ILIKE', "%{$search}%")
                  ->orWhere('payment_method', 'ILIKE', "%{$search}%");
        }
    }

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updated_user(){
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function sale()
    {
        return $this->belongsTo( Sale::class );
    }
}

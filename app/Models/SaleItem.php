<?php

namespace App\Models;

use App\User;
use App\Models\Sale;
use App\Models\Product;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sale_items';

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
        'qty' => 'integer',
        'price' => 'integer',
        'amount' => 'integer',
        'discount_amount' => 'integer'
    ];
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'product_name',
        'product_item_code',
        'qty',
        'price',
        'amount',
        'discount_amount',
        'created_by',
        'updated_by',
        'deleted_by',
       
    ];

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updated_user(){
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function product()
    {
        return $this->belongsTo( Product::class );
    }
    public function sale()
    {
        return $this->belongsTo( Sale::class );
    }

}

<?php

namespace App\Models;

use App\Models\Category;
use App\Models\OrderItem;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
        'is_available' => 'boolean',
        'exclusive_bottle' => 'boolean',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'mm_name',
        'item_code',
        'price',
        'description',
        'image_path',
        'is_available',
        'exclusive_bottle',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('mm_name', 'ILIKE', "%{$search}%");
        }
    }

    public function user(){
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function category()
    {
        return $this->belongsTo( Category::class );
    }

    public function order_items()
    {
        return $this->hasMany( OrderItem::class );
    }
}

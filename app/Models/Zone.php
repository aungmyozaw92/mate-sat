<?php

namespace App\Models;

use App\Models\City;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'zones';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','city_id','is_available', 'mm_name', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('mm_name', 'ILIKE', "%{$search}%");
        }
    }

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by');
    }
    
    public function updated_user(){
        return $this->belongsTo( User::class, 'updated_by');
    }

    public function city(){
        return $this->belongsTo( City::class);
    }
}

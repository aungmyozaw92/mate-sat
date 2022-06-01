<?php

namespace App\Models;

use App\Models\BottleReturn;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BottleReturnHistory extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bottle_return_histories';

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
        'returned_bottle' => 'integer',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bottle_return_id',
        'returned_bottle',
        'returned_date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by');
    }
    public function bottle_return(){
        return $this->belongsTo( BottleReturn::class);
    }
}

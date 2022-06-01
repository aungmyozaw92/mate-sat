<?php

namespace App\Models;

use App\User;
use App\Models\LogStatus;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_histories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'order_id' ,'log_status_id','previous','next','created_by'];
    
    public function created_user(){
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function log_status(){
        return $this->belongsTo( LogStatus::class );
    }
}

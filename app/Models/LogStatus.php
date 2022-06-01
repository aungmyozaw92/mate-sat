<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'log_statuses';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'value' ,'description','description_mm'];
   
    public function scopeStatusValue($query, $value)
    {
        return $query->where('value', $value);
    }
}

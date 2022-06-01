<?php

namespace App\Models;

use App\Models\Bank;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankInformation extends Model
{
    use SoftDeletes;
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bank_informations';

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
        'account_name',
        'account_no',
        'bank_id',
        'resourceable_type',
        'resourceable_id',
        'is_default',
        'branch_name',
        'created_by_type',
        'updated_by_type',
        'deleted_by_type',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
    ];

     public function resourceable()
    {
        return $this->morphTo()->withTrashed();
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}

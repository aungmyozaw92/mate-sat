<?php

namespace App\Models;

use App\Models\BankInformation;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banks';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name' ];

    public function bank_informations()
    {
        return $this->hasMany( BankInformation::class );
    }
}

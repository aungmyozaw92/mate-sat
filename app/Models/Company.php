<?php

namespace App\Models;

use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Uuids;

    public $incrementing = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_code',
        'logo_name',
        'logo_url',
        'thirdparty_token',
    ];
}

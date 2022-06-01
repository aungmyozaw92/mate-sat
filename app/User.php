<?php

namespace App;

use App\Models\City;
use App\Models\Department;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{

    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use HasApiTokens;
    use Uuids;

    public $incrementing = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'username', 
        'email', 
        'password',
        'phone',
        'address',
        'department_id',
        'approved_by',
        'suspend_by',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_at',
        'suspend_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function username()
    {
        return 'username';
    }

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['search']) && $search = $filter['search']) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ;
        }
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function updated_user(){
        return $this->belongsTo( User::class, 'updated_by');
    }

    public function deleted_user(){
        return $this->belongsTo( User::class, 'deleted_by');
    }

    public function created_user(){
        return $this->belongsTo( User::class, 'created_by');
    }

    public function approved_user(){
        return $this->belongsTo( User::class, 'approved_by');
    }

    public function suspend_user(){
        return $this->belongsTo( User::class, 'suspend_by');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

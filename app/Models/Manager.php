<?php

namespace App\Models;

use App\Modules\Branch\Entities\Branch;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\ManagerFactory;
use Illuminate\Notifications\Notifiable;
use App\Modules\Company\Entities\Company;
use App\Modules\Permission\Traits\Permission\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard = 'manager';

    const OWNER = 'owner';
    const FINANCE_MANAGER = 'finance_manager';
    const BRANCH_MANAGER = 'branch_manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'identification_number',
        'forget_code',
        'user_type',
        'birthdate',
        'is_active',
        'company_id',
        'blocked_key',
        'delegation_file',
        'deactivated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deactivated_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function setPasswordAttribute($password = '')
    {
        if (is_null($password) && strlen($password) == 0)
            return;
        if (!is_null($password) && strlen($password) == 60 && preg_match('/^\$2y\$/', $password)) {
            $this->attributes['password'] = $password ?? '';
        } else {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    protected static function newFactory()
    {
        return ManagerFactory::new();
    }

    public static function getTypes()
    {
        return [
            self::OWNER,
            self::FINANCE_MANAGER,
            self::BRANCH_MANAGER
        ];
    }

    public function getDelegationFileUrlAttribute()
    {
        return url("storage/{$this->delegation_file}");
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->hasOne(Branch::class);
    }

    public function scopeIsActivated($query){
       return $query->where('is_active',true);
    }

    public function getIsFinanceManagerAttribute($value)
    {
        return $this->user_type == static::FINANCE_MANAGER;
    }

    public function getIsBranchManagerAttribute($value)
    {
        return $this->user_type == static::BRANCH_MANAGER;
    }

    public function getIsOwnerAttribute($value)
    {
        return $this->user_type == static::OWNER;
    }
}

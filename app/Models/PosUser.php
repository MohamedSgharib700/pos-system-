<?php

namespace App\Models;

use App\Modules\Branch\Entities\Branch;
use App\Modules\Company\Entities\Company;
use Database\Factories\PosUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PosUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'email',
        'password',
        'phone',
        'serial_number',
        'forget_code',
        'serial_code',
        'is_active',
        'blocked_key',
        'identification_number'
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
        'is_active' => 'boolean'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function setPasswordAttribute($password = '')
    {
        if (\Hash::needsRehash($password)) {
            $password = \Hash::make($password);
        }
        $this->attributes['password'] = $password ?? '';
    }

    protected static function newFactory()
    {
        return PosUserFactory::new();
    }
   }


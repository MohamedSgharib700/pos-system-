<?php

namespace App\Models;

use App\Modules\Permission\Traits\Permission\HasRoles;
use Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\Cast\Object_;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'blocked_key',
        'forget_code',
        'deactivated_at'
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
    ];

    /**
     * ReHash the password.
     *
     * @param $password
     * @return void
     */
    public function setPasswordAttribute($password = '') :void
    {
        if (\Hash::needsRehash($password)) {
            $password = \Hash::make($password);
        }
        $this->attributes['password'] = $password ?? '';
    }

    /**
     * to define the admin factory.
     *
     * @return AdminFactory
     */
    protected static function newFactory() :object
    {
        return AdminFactory::new();
    }
}

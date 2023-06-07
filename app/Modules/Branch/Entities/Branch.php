<?php

namespace App\Modules\Branch\Entities;

use App\Models\Manager;
use App\Models\PosUser;
use App\Modules\Cities\Entities\City;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Company\Entities\Company;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Branch\Database\factories\BranchFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company_id', 'manager_id', 'city_id', 'deactivated_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function posUsers()
    {
        return $this->hasMany(PosUser::class);
    }

    protected static function newFactory()
    {
        return BranchFactory::new();
    }

    public function banksAccounts()
    {
        return $this->morphMany(BanksAccount::class, 'banksAccountable', 'model_type','model_id');
    }
}

<?php

namespace App\Modules\Company\Entities;

use App\Models\Manager;
use App\Models\PosUser;
use App\Modules\Branch\Entities\Branch;
use Illuminate\Database\Eloquent\Model;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Modules\Company\Database\factories\CompanyFactory;

class Company extends Model
{
    protected $fillable = ['name', 'tax_number', 'commercial_register', 'deactivated_at', 'type'];

    const COMMERCIAL_RECORD = 'commercial_record';
    const FREE_DOCUMENT = 'free_document';
    const FAMOUS = 'famous';

    public function owner()
    {
        return $this->hasOne(Manager::class)->whereUserType(Manager::OWNER);
    }

    public function financeManager()
    {
        return $this->hasOne(Manager::class)->whereUserType(Manager::FINANCE_MANAGER);
    }

    protected static function newFactory()
    {
        return CompanyFactory::new();
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function posUsers()
    {
        return $this->hasMany(PosUser::class);
    }

    public function banksAccounts()
    {
        return $this->morphMany(BanksAccount::class, 'banksAccountable', 'model_type','model_id');
    }


    public static function getTypes()
    {
        return [
            self::COMMERCIAL_RECORD,
            self::FREE_DOCUMENT,
            self::FAMOUS
        ];
    }
}

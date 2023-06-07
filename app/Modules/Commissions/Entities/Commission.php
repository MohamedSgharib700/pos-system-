<?php

namespace App\Modules\Commissions\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Company\Entities\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Commissions\Database\factories\CommissionFactory;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'company_id', 'deactivated_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected static function newFactory()
    {
        return CommissionFactory::new();
    }

}

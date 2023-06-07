<?php

namespace App\Modules\BanksAccounts\Entities;

use App\Modules\Banks\Entities\Bank;
use App\Modules\BanksAccounts\Database\Factories\BanksAccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanksAccount extends Model
{
    use HasFactory;

    protected $fillable = ['model_id', 'model_type', 'bank_id', 'iban', 'deactivated_at'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return BanksAccountFactory::new();
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function banksAccountable()
    {
        return $this->morphTo('banksAccountable','model_type','model_id');
    }
}

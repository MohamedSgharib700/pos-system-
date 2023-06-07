<?php

namespace App\Modules\Banks\Entities;

use App\Modules\Banks\Database\Factories\BankFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{
    use HasTranslations, HasFactory;

    protected $translatable = ['name'];
    protected $fillable = ['name', 'deactivated_at'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return BankFactory::new();
    }
}

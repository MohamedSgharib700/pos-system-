<?php

namespace App\Modules\ServicesProviders\Entities;

use App\Modules\ServicesProviders\Database\Factories\ServicesProviderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServicesProvider extends Model
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
        return ServicesProviderFactory::new();
    }
}

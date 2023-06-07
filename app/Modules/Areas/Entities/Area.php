<?php

namespace App\Modules\Areas\Entities;

use App\Modules\Areas\Database\factories\AreaFactory;
use App\Modules\Cities\Entities\City;
use App\Traits\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasTranslations, HasFactory;

    public $translatable = ['name'];
    protected $fillable = ['name'];
    protected $nullable = ['deactivated_at'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AreaFactory::new ();
    }

}

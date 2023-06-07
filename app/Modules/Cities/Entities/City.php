<?php

namespace App\Modules\Cities\Entities;

use App\Modules\Areas\Entities\Area;
use App\Modules\Cities\Database\factories\CityFactory;
use App\Traits\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasTranslations, HasFactory;

    public $translatable = ['name'];
    protected $fillable = ['name', 'area_id'];
    protected $nullable = ['deactivated_at'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CityFactory::new ();
    }
}

<?php

namespace App\Modules\Cities\Exports;

use App\Modules\Cities\Entities\City;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CityExport implements FromCollection,WithHeadings
{
    /**
     * Get Collection of cities
     *
     * @return Collection
     */
    public function collection(): Collection
    {
        return City::with('area')->get()->map(function($city) {
            return [
               'name_en'        => $city->getTranslation('name', 'en'),
               'name_ar'        => $city->getTranslation('name', 'ar'),
               'area_name_en'   => $city->area->getTranslation('name', 'en'),
               'area_name_ar'   => $city->area->getTranslation('name', 'ar'),
               'deactivated_at' => $city->deactivated_at ? "deactivated at ". date('d-m-Y', strtotime($city->deactivated_at)) : "activated",
            ];
         });
    }

    /**
     * Rename the head row of Excel sheet.
     *
     * @return string[]
     */
    public function headings(): array
    {
        return ["name_en", "name_ar", "area_name_en", "area_name_ar", "activated / deactivated"];
    }
}

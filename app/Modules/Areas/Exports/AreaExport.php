<?php

namespace App\Modules\Areas\Exports;

use App\Modules\Areas\Entities\Area;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AreaExport implements FromCollection,WithHeadings
{
    /**
     * Get collection of areas.
     *
     * @return Collection
     */
    public function collection(): Collection
    {
        return Area::get()->map(function($area) {
            return [
               'name_en'        => $area->getTranslation('name', 'en'),
               'name_ar'        => $area->getTranslation('name', 'ar'),
               'deactivated_at' => $area->deactivated_at ? "deactivated at ". date('d-m-Y', strtotime($area->deactivated_at)) : "activated",
            ];
         });
    }

    public function headings(): array
    {
        return ["name_en", "name_ar", "activated / deactivated"];
    }
}

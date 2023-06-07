<?php

namespace App\Modules\Cities\Imports;

use App\Modules\Areas\Entities\Area;
use App\Modules\Cities\Entities\City;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class CityImport implements ToCollection, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row => $value) {
            if ($row != 0) {
                $area = $this->areas->where('name', 'LIKE', '%' . $value[2] . '%')->first();
                if ($area) {
                    City::create([
                        'name' => ['en' => $value[0], 'ar' => $value[1]],
                        'area_id' => $area->id,
                    ]);
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            '0' => ['required', 'unique:cities,name->en'],
            '1' => ['required', 'unique:cities,name->ar'],
            '2' => ['required'],
            '3' => ['required'],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'name_en',
            '1' => 'name_ar',
            '2' => 'area_name_en',
            '3' => 'area_name_ar',
        ];
    }
}
